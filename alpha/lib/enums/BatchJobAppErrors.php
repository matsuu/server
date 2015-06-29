<?php
/**
 * @package Core
 * @subpackage model.enum
 */ 
interface BatchJobAppErrors extends BaseEnum
{
	const OUTPUT_FILE_DOESNT_EXIST = 11;
	const OUTPUT_FILE_WRONG_SIZE = 12;
	const CANNOT_CREATE_DIRECTORY = 13;
	const FILE_ALREADY_EXISTS = 14;	
	
	const NFS_FILE_DOESNT_EXIST = 21;
	
	const EXTRACT_MEDIA_FAILED = 31;
	const BLACK_OR_SILENT_CONTENT = 32;
	
	const CLOSER_TIMEOUT = 41;
	
	const ENGINE_NOT_FOUND = 51;
	
	const REMOTE_FILE_NOT_FOUND = 61;
	const REMOTE_DOWNLOAD_FAILED = 62;
	
	//Bulk upload exceptions
	const BULK_FILE_NOT_FOUND = 71;
	const BULK_VALIDATION_FAILED = 72;
	const BULK_PARSE_ITEMS_FAILED = 73;
	const BULK_UNKNOWN_ERROR = 74;
	const BULK_INVLAID_BULK_REQUEST_COUNT = 75;
	const BULK_NO_ENTRIES_HANDLED = 76;
	const BULK_ACTION_NOT_SUPPORTED = 77;
	const BULK_MISSING_MANDATORY_PARAMETER = 78;
	const BULK_ITEM_VALIDATION_FAILED = 79;
	const BULK_ITEM_NOT_FOUND = 701;
	const BULK_ELEMENT_NOT_FOUND = 702;
		
	const CONVERSION_FAILED = 81;
	
	const THUMBNAIL_NOT_CREATED = 91;
	
	const MISSING_PARAMETERS = 92;
	
	const EXTERNAL_ENGINE_ERROR = 93;

	const MISSING_ASSETS = 101;
}
