<?php

namespace Utils\test;

use PHPUnit\Framework\TestCase;
use Utils\PiiData\CustomerHelper;
use Utils\PiiData\CustomerDataDTO;
use Illuminate\Support\Facades\DB;

/**
 * Test case for the CustomerHelper class to verify DB:: facade usage
 * 
 * These tests confirm the package is correctly using the Laravel DB facade
 * instead of app('db') for PHP 8.4 and Laravel 12 compatibility
 */
class CustomerHelperTest extends TestCase
{
    /**
     * Set up mocks before running tests
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock the TLog class to prevent errors
        if (!class_exists('twid\logger\Facades\TLog')) {
            eval('namespace twid\logger\Facades; class TLog { public static function error() {} public static function info() {} }');
        }
    }
    
    /**
     * Test that the CustomerHelper class is using DB:: facade instead of app('db')
     * This is a static code review test rather than a functional test
     */
    public function testDBFacadeUsage()
    {
        // Load the CustomerHelper class file
        $helperFile = file_get_contents(__DIR__ . '/../PiiData/CustomerHelper.php');
        
        // Check for DB facade import
        $this->assertStringContainsString('use Illuminate\Support\Facades\DB;', $helperFile);
        
        // Check that methods are using DB::connection() not app('db')
        $this->assertStringContainsString('DB::connection(', $helperFile);
        
            // Check that we're not using app('db') in function calls
            $this->assertEquals(
                0,
                preg_match('/\bapp\s*\(\s*[\'"]db[\'"]\s*\)\s*->/', $helperFile), 
                "Code should not contain app('db') or app(\"db\") function calls"
            );        // Verify that DB::connection is used in key methods
        $this->assertStringContainsString('DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)', $helperFile);
        $this->assertStringContainsString('DB::connection(PII_DATABASE_CONNECTION)', $helperFile);
    }
    
    /**
     * Test that the CustomerHelper class methods use constants for connections
     * This ensures consistency and maintainability
     */
    public function testConnectionConstants()
    {
        // Load the CustomerHelper class file
        $helperFile = file_get_contents(__DIR__ . '/../PiiData/CustomerHelper.php');
        
        // Check for database connection constants
        $this->assertStringContainsString('const PII_READ_ONLY_DATABASE_CONNECTION = \'mysql_read1\';', $helperFile);
        $this->assertStringContainsString('const PII_DATABASE_CONNECTION = \'mysql\';', $helperFile);
        
        // Verify constants are used throughout the class
        $this->assertStringContainsString('DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)', $helperFile);
        $this->assertStringContainsString('DB::connection(PII_DATABASE_CONNECTION)', $helperFile);
    }
    
    /**
     * Test that chunkCustomersByCreatedAt method uses DB facade 
     * This method was specifically updated from app('db') to DB facade
     */
    public function testChunkMethodUsesFacade()
    {
        // Load the CustomerHelper class file
        $helperFile = file_get_contents(__DIR__ . '/../PiiData/CustomerHelper.php');
        
        // Extract the chunkCustomersByCreatedAt method text
        if (preg_match('/public static function chunkCustomersByCreatedAt.*?}\s*}/s', $helperFile, $matches)) {
            $methodCode = $matches[0];
            
            // Check that the method uses DB facade
            $this->assertStringContainsString('DB::connection(', $methodCode);
            
            // Check that we're not using app('db') in function calls
            $this->assertEquals(
                0,
                preg_match('/\bapp\s*\(\s*[\'"]db[\'"]\s*\)\s*->/', $methodCode),
                "Code should not contain app('db') or app(\"db\") function calls"
            );
            
            // Verify correct DB::connection usage
            $this->assertStringContainsString('DB::connection(PII_READ_ONLY_DATABASE_CONNECTION)', $methodCode);
        } else {
            $this->fail('Could not find chunkCustomersByCreatedAt method in CustomerHelper.php');
        }
    }
    
    /**
     * Test that CustomerDataDTO class has proper PHP 8 type hints
     * for Laravel 12 compatibility
     */
    public function testDataDTOTypeHints()
    {
        // Load the CustomerDataDTO class file
        $dtoFile = file_get_contents(__DIR__ . '/../PiiData/CustomerDataDTO.php');
        
        // Check for property type hints
        $this->assertStringContainsString('private int $id;', $dtoFile);
        $this->assertStringContainsString('private string $mobileNumber;', $dtoFile);
        
        // Check for return type hints
        $this->assertStringContainsString('public function getId(): int', $dtoFile);
        $this->assertStringContainsString('public function getMobileNumber(): string', $dtoFile);
        
        // Check for parameter type hints
        $this->assertStringContainsString('public function setId(int $id)', $dtoFile);
        $this->assertStringContainsString('public function setMobileNumber(string $mobileNumber)', $dtoFile);
    }
}