<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProductSubCategoryImageBulk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saiya:sync-subcategory-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Sub Category Image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $slugs = [
            'saiya-acoustic-guitars-360g' => '/images/acoustic/360G/SW-360G/acoustic-360G-SW-360G-eqxwkr.webp',
            'saiya-acoustic-guitars-400c' => '/images/acoustic/400C/GF-400C-NT/acoustic-400C-GF-400C-NT-k3d165.webp',
            'saiya-acoustic-guitars-ae' => '/images/acoustic/AE/AEFC-240/acoustic-AE-AEFC-240-j5gr6p.webp',
            'saiya-acoustic-guitars-fg-150' => '/images/acoustic/FG-150/FG-150-OPW/acoustic-FG-150-FG-150-OPW-o2gdfe.webp',
            'saiya-acoustic-guitars-fsc' => '/images/acoustic/FSC/FSC-TK/acoustic-FSC-FSC-TK-lksjlt.webp',
            'saiya-acoustic-guitars-iw-240' => '/images/acoustic/IW-240/IW-240-MNS/acoustic-IW-240-IW-240-MNS-axx1v4.webp',
            'saiya-acoustic-guitars-mindi' => '/images/acoustic/MINDI/IWC-240D-NA/acoustic-MINDI-IWC-240D-NA-c9u82g.webp',
            'saiya-acoustic-guitars-mini' => '/images/acoustic/MINI/AEG-MINI-3/acoustic-MINI-AEG-MINI-3-hvgebg.webp',
            'saiya-acoustic-guitars-tk' => '/images/acoustic/TK/TKC-240/acoustic-TK-TKC-240-n4o4eg.webp',
            'saiya-bass-ae-bass' => '/images/bass/AE-BASS/bass-AE-BASS-AE-BASS-gqkfzs.webp',
            'saiya-bass-mini-bass' => '/images/bass/MINI-BASS/bass-MINI-BASS-MINI-BASS-zzy0nn.webp',
            'saiya-bass-tk-bass' => '/images/bass/TK-BASS/bass-TK-BASS-TK-BASS-0gykih.webp',
            'saiya-classic-guitars-ic-100-na' => '/images/classic/IC-100-NA/classic-IC-100-NA-IC-100-NA-n07xyg.webp',
            'saiya-classic-guitars-ic-100dc-na' => '/images/classic/IC-100DC-NA/classic-IC-100DC-NA-IC-100DC-NA-jpoc6r.webp',
            'saiya-classic-guitars-ic-100tce' => '/images/classic/IC-100TCE/classic-IC-100TCE-IC-100TCE-mjbj81.webp',
            'saiya-electric-guitars-ak-s90-hnl' => '/images/electric/AK-S90-HNL/electric-AK-S90-HNL-AK-S90-HNL-c0nzrw.webp',
            'saiya-electric-guitars-eb-s60mini-knl' => '/images/electric/EB-S60MINI-KNL/electric-EB-S60MINI-KNL-EB-S60MINI-KNL-22mgks.webp',
            'saiya-electric-guitars-eb-s68-sdnl' => '/images/electric/EB-S68-SDNL/electric-EB-S68-SDNL-EB-S68-SDNL-kp1k39.webp',
            'saiya-electric-guitars-eb-s90-knl' => '/images/electric/EB-S90-KNL/electric-EB-S90-KNL-EB-S90-KNL-powojj.webp',
            'saiya-electric-guitars-eb-t60-sdnl' => '/images/electric/EB-T60-SDNL/electric-EB-T60-SDNL-EB-T60-SDNL-rlk798.webp',
            'saiya-electric-guitars-jb10-bk' => '/images/electric/JB10-BK/electric-JB10-BK-JB10-BK-fsz0uk.webp',
            'saiya-electric-guitars-k-b71-5-sdnl' => '/images/electric/K-B71-5-SDNL/electric-K-B71-5-SDNL-K-B71-5-SDNL-n375cl.webp',
            'saiya-electric-guitars-m-b60-ns' => '/images/electric/M-B60-NS/electric-M-B60-NS-M-B60-NS-nk5995.webp',
            'saiya-electric-guitars-pb10-sb' => '/images/electric/PB10-SB/electric-PB10-SB-PB10-SB-rvsvoq.webp',
            'saiya-electric-guitars-s10-rd' => '/images/electric/S10-RD/electric-S10-RD-S10-RD-mbttp2.webp',
            'saiya-electric-guitars-s10b-sb' => '/images/electric/S10B-SB/electric-S10B-SB-S10B-SB-2rwepr.webp',
            'saiya-electric-guitars-s20-wh' => '/images/electric/S20-WH/electric-S20-WH-S20-WH-ixs2s5.webp',
            'saiya-electric-guitars-sd-nx2-dnl' => '/images/electric/SD-NX2-DNL/electric-SD-NX2-DNL-SD-NX2-DNL-5qx5tc.webp',
            'saiya-electric-guitars-sd-s60mini-knl' => '/images/electric/SD-S60MINI-KNL/electric-SD-S60MINI-KNL-SD-S60MINI-KNL-pz2geb.webp',
            'saiya-electric-guitars-sd-s80-dnl' => '/images/electric/SD-S80-DNL/electric-SD-S80-DNL-SD-S80-DNL-mkos9q.webp',
            'saiya-electric-guitars-sd-s90-dnl' => '/images/electric/SD-S90-DNL/electric-SD-S90-DNL-SD-S90-DNL-nzixj4.webp',
            'saiya-electric-guitars-sd-t60-knl' => '/images/electric/SD-T60-KNL/electric-SD-T60-KNL-SD-T60-KNL-bvank1.webp',
            'saiya-electric-guitars-t-b71-knl' => '/images/electric/T-B71-KNL/electric-T-B71-KNL-T-B71-KNL-1w56kt.webp',
            'saiya-electric-guitars-t-nx2-knl' => '/images/electric/T-NX2-KNL/electric-T-NX2-KNL-T-NX2-KNL-lmlm4d.webp',
            'saiya-electric-guitars-t-s68-dnl' => '/images/electric/T-S68-DNL/electric-T-S68-DNL-T-S68-DNL-y512q9.webp',
            'saiya-electric-guitars-t-s80-knl' => '/images/electric/T-S80-KNL/electric-T-S80-KNL-T-S80-KNL-9azs2n.webp',
            'saiya-electric-guitars-t10-bk' => '/images/electric/T10-BK/electric-T10-BK-T10-BK-nstzp2.webp',
            'saiya-ukulele-ak' => '/images/ukulele/AK/AKF-21 WNS/ukulele-AK-AKF-21-WNS-ylknv2.webp',
            'saiya-ukulele-ek' => '/images/ukulele/EK/EK-25 WNS/ukulele-EK-EK-25-WNS-r9jvrt.webp',
            'saiya-ukulele-euc' => '/images/ukulele/EUC/EUC-KWNS/ukulele-EUC-EUC-KWNS-v72fz4.webp',
            'saiya-ukulele-uk' => '/images/ukulele/UK/UK-21 WTNS/ukulele-UK-UK-21-WTNS-mj349r.webp',
            'saiya-ukulele-uk-color' => '/images/ukulele/UK-COLOR/UK-GRASSHOPPER/ukulele-UK-COLOR-UK-GRASSHOPPER-ern26h.webp',
            'saiya-ukulele-uk-ml' => '/images/ukulele/UK-ML/UK-ML-21D NS/ukulele-UK-ML-UK-ML-21D-NS-5fdtyp.webp',
            'saiya-ukulele-uk-pw' => '/images/ukulele/UK-PW/UK-PWC/ukulele-UK-PW-UK-PWC-pms4yi.webp',
            'saiya-ukulele-ukf' => '/images/ukulele/UKF/UKF-21 WTNS/ukulele-UKF-UKF-21-WTNS-4rc6g9.webp',
        ];

        foreach ($slugs as $slug => $imagePath) {
            $productSubCategory = \App\Models\ProductSubCategory::where('slug', $slug)->first();
            if ($productSubCategory) {
                $productSubCategory->image = $imagePath;
                $productSubCategory->save();
            }
        }
    }
}