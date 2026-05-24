<?php

namespace App\Exports;

use App\Models\AnalysisHeader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ApuDetailedExport implements WithMultipleSheets
{
    protected $apuId;
    
    public function __construct($apuId = null)
    {
        $this->apuId = $apuId;
    }
    
    public function sheets(): array
    {
        if ($this->apuId) {
            $apu = AnalysisHeader::findOrFail($this->apuId);
            
            return [
                new ApuSummarySheet($apu),
                new ApuEquipmentSheet($apu),
                new ApuLaborSheet($apu),
                new ApuMaterialsSheet($apu),
                new ApuTransportSheet($apu),
            ];
        }
        
        return [
            new AllApusSheet(),
        ];
    }
}