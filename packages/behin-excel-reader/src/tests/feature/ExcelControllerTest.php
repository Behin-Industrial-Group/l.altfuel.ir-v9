<?php

namespace ExcelReader\Tests\Feature;

use ExcelReader\Controllers\ExcelController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Tests\TestCase;
use Mockery;

class ExcelControllerTest extends TestCase
{
    public function test_file_validation()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('test.docx', 100);

        $response = $this->post('/excel/excel-reader', [
            'file' => $file,
        ]);

        $response->assertSessionHasErrors(['file']);
    }

    public function test_file_processing()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('test.xlsx', 100);

        $xlsxMock = Mockery::mock('alias:ExcelReader');
        $xlsxMock->shouldReceive('parse')->andReturn(true);

        $response = $this->post('/excel/excel-reader', [
            'file' => $file,
        ]);

        $response->assertStatus(400);
        $this->assertDatabaseHas('agency_info', [
            'key' => 'customer_type',
        ]);
    }

    public function test_database_storage()
    {
        $data = [
            'key' => 'customer_type',
            'value' => 'individual',
            'parent_id' => null,
        ];

        $parentRecord = AgencyInfo::create($data);
        $parentId = $parentRecord->id;

        $parentRecord->parent_id = $parentId;
        $parentRecord->save();

        $this->assertDatabaseHas('agency_info', [
            'key' => 'customer_type',
            'value' => 'individual',
            'parent_id' => $parentRecord->id,
        ]);
    }

    public function test_header_rename_and_filter()
    {
        $data = [
            'کد ملی' => '1234567890',
            'کد پستی' => '12345',
            'شماره موبایل' => '09123456789',
            'نوع مشتری' => 'individual',
            'غیر مرتبط' => 'value',
        ];

        $result = ExcelController::headerRenameAndFilter($data);

        $this->assertEquals([
            'national_id' => '1234567890',
            'postal_code' => '12345',
            'mobile' => '09123456789',
            'customer_type' => 'individual',
        ], $result);
    }

    public function test_read_with_incomplete_data()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('test.xlsx', 100);
        $xlsxMock = Mockery::mock('alias:ExcelReader');
        $xlsxMock->shouldReceive('parse')
            ->andReturn(true);
        $xlsxMock->shouldReceive('rows')
            ->andReturn([
                ['کد ملی', 'کد پستی', 'شماره موبایل', 'نوع مشتری'],
                ['1234567890', '12345', '09123456789'], // بدون نوع مشتری
            ]);

        $response = $this->post('/excel/excel-reader', [
            'file' => $file,
        ]);

        $response->assertStatus(400);

    }

}
