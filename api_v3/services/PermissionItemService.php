<?php

/**
 * PermissionItem service lets you create and manage permission items
 * @service permissionItem
 * @package api
 * @subpackage services
 */
class PermissionItemService extends KalturaBaseService
{
	public function initService($serviceName, $actionName)
	{
		parent::initService($serviceName, $actionName);
	}	

	
	/**
	 * Allows you to add a new KalturaPermissionItem object
	 * 
	 * @action add
	 * @param KalturaPermissionItem $permissionItem
	 * @return KalturaPermissionItem
	 * 
	 * @throws KalturaErrors::PROPERTY_VALIDATION_CANNOT_BE_NULL
	 * @throws KalturaErrors::PROPERTY_VALIDATION_NOT_UPDATABLE
	 */
	public function addAction(KalturaPermissionItem $permissionItem)
	{
		$permissionItem->validateForInsert();
		$permissionItem->validatePropertyNotNull('permissionId');
		$permissionItem->validatePropertyNotNull('type');
							
		$dbPermissionItem = $permissionItem->toInsertableObject();
		$dbPermissionItem->save();
		
		$permissionItem = new KalturaPermissionItem();
		$permissionItem->fromObject($dbPermissionItem);
		
		return $permissionItem;
	}
	
	/**
	 * Retrieve a KalturaPermissionItem object by ID
	 * 
	 * @action get
	 * @param int $permissionItemId 
	 * @return KalturaPermissionItem
	 * 
	 * @throws KalturaErrors::INVALID_OBJECT_ID
	 */		
	public function getAction($permissionItemId)
	{
		$dbPermissionItem = PermissionItemPeer::retrieveByPK($permissionItemId);
		
		if (!$dbPermissionItem) {
			throw new KalturaAPIException(KalturaErrors::INVALID_OBJECT_ID, $permissionItemId);
		}
			
		if ($dbPermissionItem->getType() == PermissionItemType::API_ACTION_ITEM) {
			$permissionItem = new KalturaApiActionPermissionItem();
		}
		else if ($dbPermissionItem->getType() == PermissionItemType::API_PARAMETER_ITEM) {
			$permissionItem = new KalturaApiParameterPermissionItem();
		}
		else {
			$permissionItem = new KalturaPermissionItem();
		}
		
		$permissionItem->fromObject($dbPermissionItem);
		
		return $permissionItem;
	}


	/**
	 * Update an existing KalturaPermissionItem object
	 * 
	 * @action update
	 * @param int $permissionItemId
	 * @param KalturaPermissionItem $permissionItem
	 * @return KalturaPermissionItem
	 *
	 * @throws KalturaErrors::INVALID_OBJECT_ID
	 */	
	public function updateAction($permissionItemId, KalturaPermissionItem $permissionItem)
	{
		$dbPermissionItem = PermissionItemPeer::retrieveByPK($permissionItemId);
	
		if (!$dbPermissionItem) {
			throw new KalturaAPIException(KalturaErrors::INVALID_OBJECT_ID, $permissionItemId);
		}
		
		$dbPermissionItem = $permissionItem->toUpdatableObject($dbPermissionItem);
		$dbPermissionItem->save();
	
		$permissionItem = new KalturaPermissionItem();
		$permissionItem->fromObject($dbPermissionItem);
		
		return $permissionItem;
	}

	/**
	 * Mark the KalturaPermissionItem object as deleted
	 * 
	 * @action delete
	 * @param int $permissionItemId 
	 * @return KalturaPermissionItem
	 *
	 * @throws KalturaErrors::INVALID_OBJECT_ID
	 */		
	public function deleteAction($permissionItemId)
	{
		$dbPermissionItem = PermissionItemPeer::retrieveByPK($permissionItemId);
	
		if (!$dbPermissionItem) {
			throw new KalturaAPIException(KalturaErrors::INVALID_OBJECT_ID, $permissionItemId);
		}
		
		$dbPermissionItem->setStatus(KalturaPermissionStatus::DELETED);
		$dbPermissionItem->save();
			
		$permissionItem = new KalturaPermissionItem();
		$permissionItem->fromObject($dbPermissionItem);
		
		return $permissionItem;
	}
	
	/**
	 * List KalturaPermissionItem objects
	 * 
	 * @action list
	 * @param KalturaPermissionItemFilter $filter
	 * @param KalturaFilterPager $pager
	 * @return KalturaPremissionItemListResponse
	 */
	public function listAction(KalturaPermissionItemFilter  $filter = null, KalturaFilterPager $pager = null)
	{
		if (!$filter)
			$filter = new KalturaPermissionItemFilter();
			
		$permissionItemFilter = $filter->toObject();
		
		$c = new Criteria();
		$permissionItemFilter->attachToCriteria($c);
		$count = PermissionItemPeer::doCount($c);
		
		if ($pager)
			$pager->attachToCriteria($c);
		$list = PermissionItemPeer::doSelect($c);
		
		$response = new KalturaPremissionItemListResponse();
		$response->objects = KalturaPermissionItemArray::fromDbArray($list);
		$response->totalCount = $count;
		
		return $response;
	}	
}
