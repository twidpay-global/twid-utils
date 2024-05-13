<?php 
/**
 * PIIDataHelper class
 * It will create a layer between the PII data and the application
 * The class will be responsible for handling the PII data
 * And will contain the logic to CRUD PII data from a diiferent database 
 * 
 *
 * PHP version 8
 *
 * LICENSE: This source file is subject to version 8.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/7_1.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  PIIDataHelper
 * @package   Helper
 * @author    Original Author <harshit.chaudhary@twidpay.com>
 * @copyright 2020-2024 The Twid Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 8.0
 * @version   SVN: 1.1
 * @link      http://twidpay.com/app/Helpers/PIIDataHelper.php
 * @see       NetOther, Net_Sample::Net_Sample()
 * @since     File available since Release 1.0.1
 */

namespace Utils\PiiData;

use Illuminate\Support\Facades\DB;
use twid\logger\Facades\TLog;

const PII_DATA_TABLE = 'customer_pii_data';
const PII_DATABASE_CONNECTION = 'mysql_read1';

class PIIDataHelper {

    /**
     * createCustomerPIIData method
     * This method will create a new customer's PII data and store it in the different database
     * 
     * @param array $data The data to be stored
     * 
     * @return bool
     */
    public function createCustomerPIIData(array $data) : bool
    {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->insert($data);
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Data' => $data]);
            return false;
        }
    }

    /**
     * getCustomerIDByMobile method
     * This method will return the customer ID from PII data by mobile number
     * 
     * @param string $mobile The mobile number to search
     * 
     * @return int
     */
    public function getCustomerIDByMobile(string $mobile) : int {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->select('customer_id')
                ->where('mobile', $mobile)
                ->first();
            return $result->customer_id;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
            return 0;
        }
    }

    /**
     * getCustomersPIIDataByMobiles method
     * This method will return the customer IDs from PII data by mobile numbers
     * It takes the string ... of the fields that need to be fetched from PII data table
     * 
     * @param array $mobiles The mobile numbers to search
     * @param string ...$fields The fields to be fetched
     * 
     * @return array
     */

    public function getCustomersPIIDataByMobiles(array $mobiles, string ...$fields) : array {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->select($fields)
                ->whereIn('mobile', $mobiles)
                ->get();
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobiles' => $mobiles]);
            return [];
        }
    }

    /**
     * getCustomersPIIDataByCustomerIDs method
     * This method will return the customer IDs from PII data by customer IDs
     * It takes the ..string of the fields that need to be fetched from PII data table
     * 
     * @param array $customer_ids The customer IDs to search
     * @param string ...$fields The fields to be fetched
     * 
     * @return array
     */

    public function getCustomersPIIDataByCustomerIDs(array $customer_ids, string ...$fields) : array {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->select($fields)
                ->whereIn('customer_id', $customer_ids)
                ->get();
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer IDs' => $customer_ids]);
            return [];
        }
    }

    /**
     * getCustomerPIIDataByCustomerID method
     * This method will return the customer's PII data by customer ID
     * 
     * @param int $customer_id The customer ID to search
     * @param string ...$fields The fields to be fetched
     * 
     * @return array
     */
    public function getCustomerPIIDataByCustomerID(int $customer_id, string ...$fields) : array {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->select($fields)
                ->where('customer_id', $customer_id)
                ->first();
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer ID' => $customer_id]);
            return [];
        }
    }

    /**
     * getCustomerPIIDataByMobile method
     * This method will return the customer's PII data by mobile number
     * 
     * @param string $mobile The mobile number to search
     * @param string ...$fields The fields to be fetched
     */
    public function getCustomerPIIDataByMobile(string $mobile, string ...$fields) : array {
        try {
            // calling the getCustomerIDByMobile method to get the customer ID
            $customer_id = $this->getCustomerIDByMobile($mobile);
            // calling the getCustomerPIIDataByCustomerID method to get the customer PII data
            $result = $this->getCustomerPIIDataByCustomerID($customer_id, ...$fields);
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
            return [];
        }
    }



    /**
     * updateCustomerPIIData method
     * This method will update the customer's PII data in the different database
     * 
     * @param array $data The data to be updated
     * @param int $customer_id The customer ID to be updated
     * 
     * @return bool
     */

    public function updateCustomerPIIData(array $data, int $customer_id) : bool {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->where('customer_id', $customer_id)
                ->update($data);
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Data' => $data]);
            return false;
        }
    }

    /**
     * deleteCustomerPIIData method
     * This method will soft delete the customer's PII data from the different database
     * 
     * @param int $customer_id The customer ID to be deleted
     * 
     * @return bool
     */
    public function deleteCustomerPIIData(int $customer_id) : bool {
        try {
            $result = DB::connection(PII_DATABASE_CONNECTION)
                ->table(PII_DATA_TABLE)
                ->where('customer_id', $customer_id)
                ->delete();
            return $result;
        } catch (\Exception $ex) {
            TLog::error($ex->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer ID' => $customer_id]);
            return false;
        }
    }

    /**
     * maskPIIData static method
     * This method will mask the PII data
     * 
     * @param array $data The data to be masked
     * @param array $fields The fields to be masked
     * 
     * @return array
     */
    public static function maskPIIData(array $data, string ...$fields) : array {
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '********';
            }
        }
        return $data;
    }

    /**
     * unmaskPIIData static method
     * This method will unmask the PII data, 
     * It will be unmasked based on the customer data from 
     * 
     * @param array $data The data to be unmasked
     * @param array $fields The fields to be unmasked
     * 
     * @return array
     */
    public static function unmaskPIIData(array $data, array $fields) : array {
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field];
            }
        }
        return $data;
    }
}