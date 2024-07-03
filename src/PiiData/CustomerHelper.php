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

use Exception;
use Illuminate\Support\Facades\DB;
use twid\logger\Facades\TLog;

const PII_READ_ONLY_DATABASE_CONNECTION = 'mysql_read1';
const PII_DATABASE_CONNECTION = 'mysql';

class CustomerHelper
{
    /**
     * getCustomerIDByMobile method
     * This method will return the customer ID from PII data by mobile number
     *
     * @param string $mobile The mobile number to search
     *
     * @return int Customer ID
     */
    public static function getCustomerIDByMobile(string $mobile): int
    {
        try {
            $result = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->where('orig_mobile', $mobile)
                ->first();

            if ($result) {
                return $result->entity_id;
            }

            TLog::error("No customer found with the provided mobile number", ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
            throw $exception;
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
     * @return array Bulk of CustomerDataDTO
     */

    public static function getCustomersDataByMobiles(array $mobiles, string ...$fields): array
    {
        try {
            if ($fields === []) {
                $fields = ['entity_id', 'orig_mobile'];
            }

            $results = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->whereIn('orig_mobile', $mobiles)
                ->get();

            $customerDataArray = [];

            if ($results) {
                foreach ($results as $result) {
                    $data = [];
                    foreach ($fields as $field) {
                        if (isset($result->{$field})) {
                            if ($field === 'entity_id') {
                                $data['id'] = $result->{$field};
                            } elseif ($field === 'orig_mobile') {
                                $data['mobileNumber'] = $result->{$field};
                            } else {
                                $data[$field] = $result->{$field};
                            }
                        }
                    }

                    $customerDataArray[] = new CustomerDataDTO($data);
                }

                return $customerDataArray;
            }

            TLog::error("No customers found with the provided mobile numbers", ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobiles' => $mobiles]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobiles' => $mobiles]);
            throw $exception;
        }
    }

    /**
     * getCustomerPIIDataByMobile method
     * This method will return the customer's PII data by mobile number
     *
     * @param string $mobile The mobile number to search
     * @param string ...$fields The fields to be fetched
     * 
     * @return object CustomerDataDTO
     */
    public static function getCustomerDataByMobile(string $mobile, string ...$fields): CustomerDataDTO
    {
        try {
            if ($fields === []) {
                $fields = ['entity_id', 'orig_mobile'];
            }

            $result = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->select($fields)
                ->where('orig_mobile', $mobile)
                ->first();

            if ($result) {
                $data = [];
                foreach ($fields as $field) {
                    if (isset($result->{$field})) {
                        if ($field === 'entity_id') {
                            $data['id'] = $result->{$field};
                        } elseif ($field === 'orig_mobile') {
                            $data['mobileNumber'] = $result->{$field};
                        } else {
                            $data[$field] = $result->{$field};
                        }
                    }
                }

                return new CustomerDataDTO($data);
            }

            TLog::error("No customer found with the provided mobile number", ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Mobile' => $mobile]);
            throw $exception;
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
     * @return array Bulk of CustomerDataDTO
     */

    public static function getCustomerDataByCustomerIDs(array $customer_ids, string ...$fields): array
    {
        try {
            if ($fields === []) {
                $fields = ['entity_id', 'orig_mobile'];
            }

            $results = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->whereIn('entity_id', $customer_ids)
                ->get();

            $customerDataArray = [];

            if ($results) {
                foreach ($results as $result) {
                    $data = [];
                    foreach ($fields as $field) {
                        if (isset($result->{$field})) {
                            if ($field === 'entity_id') {
                                $data['id'] = $result->{$field};
                            } elseif ($field === 'orig_mobile') {
                                $data['mobileNumber'] = $result->{$field};
                            } else {
                                $data[$field] = $result->{$field};
                            }
                        }
                    }

                    $customerDataArray[] = new CustomerDataDTO($data);
                }

                return $customerDataArray;
            }

            TLog::error("No customers found with the provided customer IDs", ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer IDs' => $customer_ids]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer IDs' => $customer_ids]);
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
     * @return object CustomerDataDTO
     */
    public static function getCustomerPIIDataByCustomerID(int $customer_id, string ...$fields): CustomerDataDTO
    {
        try {
            if ($fields === []) {
                $fields = ['entity_id', 'orig_mobile'];
            }

            $result = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->select($fields)
                ->where('entity_id', $customer_id)
                ->first();

            if ($result) {
                $data = [];
                foreach ($fields as $field) {
                    if (isset($result->{$field})) {
                        if ($field === 'entity_id') {
                            $data['id'] = $result->{$field};
                        } elseif ($field === 'orig_mobile') {
                            $data['mobileNumber'] = $result->{$field};
                        } else {
                            $data[$field] = $result->{$field};
                        }
                    }
                }

                return new CustomerDataDTO($data);
            }

            TLog::error("No customer found with the provided customer ID", ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer ID' => $customer_id]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Customer ID' => $customer_id]);
            throw $exception;
        }
    }

    /**
     * getCustomerDataByFilters method
     * This method will return the customer's PII data by provided filters
     *
     * @param array $filters The field name and value to search from
     * @param string ...$fields The fields to be fetched
     * 
     * @return object CustomerDataDTO
     */
    public static function getCustomerDataByFilters(array $filters, string ...$fields): CustomerDataDTO
    {
        try {
            if ($fields === []) {
                $fields = ['entity_id', 'orig_mobile'];
            }

            $query = DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->select($fields);

            foreach ($filters as $field => $value) {
                $query =  $query->where($field, $value);
            }

            $result =  $query->first();

            if ($result) {
                $data = [];
                foreach ($fields as $field) {
                    if (isset($result->{$field})) {
                        if ($field === 'entity_id') {
                            $data['id'] = $result->{$field};
                        } elseif ($field === 'orig_mobile') {
                            $data['mobileNumber'] = $result->{$field};
                        } else {
                            $data[$field] = $result->{$field};
                        }
                    }
                }

                return new CustomerDataDTO($data);
            }

            TLog::error("No customer found with the provided filters", ['Method' => __METHOD__, 'Line' => __LINE__, 'Filters' => json_encode($filters)]);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Filters' => json_encode($filters)]);
            throw $exception;
        }
    }

    /**
     * updatePiiData method
     * This method will update the customer's PII data by customer ID
     *
     * @param int $customer_id The customer ID to update
     * @param array $data The data to be updated
     *
     * @return bool status of the update
     */
    public static function updatePiiData(int $customer_id, array $data): bool
    {
        try {
            if (!empty($data['orig_mobile'])) {
                return DB::connection(PII_DATABASE_CONNECTION)
                    ->table('c_customer_additional')
                    ->where('customer_id', $customer_id)
                    ->update(['mobile' => $data['orig_mobile']]);
            }

            return DB::connection(PII_DATABASE_CONNECTION)
                ->table('customer_entity')
                ->where('entity_id', $customer_id)
                ->update($data);
        } catch (\Exception $exception) {
            TLog::error($exception->getMessage(), ['Method' => __METHOD__, 'Line' => __LINE__, 'Data' => json_encode($data), 'Customer ID' => $customer_id]);
            throw $exception;
        }
    }
}