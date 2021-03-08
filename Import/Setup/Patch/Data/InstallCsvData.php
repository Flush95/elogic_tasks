<?php

namespace Elogic\Import\Setup\Patch\Data;

use Exception;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class InstallCsvData implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var Csv
     */
    private Csv $csv;

    /**
     * @var string
     */
    private string $csvFilePath;

    /**
     * InstallCsvData constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Csv $csv
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Csv $csv
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->csv = $csv;
    }

    /**
     *  Import values
     */
    public function apply(): void
    {
        $connection = $this->moduleDataSetup->getConnection();

        $filePath = self::getCsvFilePath();

        $tableName = $this->moduleDataSetup->getTable('elogic_shops');
        $csvData = null;
        try {
            $csvData = $this->csv->getData($filePath);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $connection->beginTransaction();
            $columns = [
                'shop_id',
                'shop_name',
                'description',
                'img_url',
                'shop_city',
                'shop_zip',
                'shop_state',
                'shop_address',
                'work_schedule',
                'holiday_work_schedule',
                'latitude',
                'longitude'
            ];

            foreach ($csvData as $rowNumber => $data) {
                $insertedData = array_combine($columns, $data);

                $connection->insertOnDuplicate(
                    $tableName,
                    $insertedData,
                    $columns
                );
            }
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollBack();
            echo $e->getMessage();
        }
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return '5.7.7';
    }

    /**
     * @return string
     */
    private function getCsvFilePath(): string
    {
        return $this->csvFilePath;
    }

    /**
     * @param $csvFilePath
     */
    public function setCsvFilePath($csvFilePath): void
    {
        $this->csvFilePath = $csvFilePath;
    }
}
