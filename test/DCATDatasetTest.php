<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATDataset;


class DCATDatasetTest extends TestCase {

    public function testEmptyDatasetsDoNotValidate(): void
    {
        $dataset = new DCATDataset();

        $this->assertFalse($dataset->validate()->validated());
    }

}
