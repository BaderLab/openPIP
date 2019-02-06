<?php

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, "http://biit.cs.ut.ee/gprofiler/index.cgi?organism=hsapiens&query=ZNF232%20TRAK1%20ZNF263%20EFEMP2%20SCAND1%20TRIM41%20PLEKHF2%20SPG21%20SUFU%20NME7%20CLK2%20CLK3%20GPATCH2L%20TCAF1%20PPL%20ZSCAN22%20ZNF165%20LNX1%20JAKMIP2%20ZNF446%20ZSCAN9%20ZNF24%20ZNF496%20DGCR6L%20ZSCAN16%20ZSCAN32%20ZNF397%20TRIM27%20KRTAP10-3%20PIN1%20KRT40%20NOTCH2NL%20PGBD1%20ZNF396%20LZTS2%20ZKSCAN7%20ZSCAN21%20GOLGA6L9%20CYSRT1%20ZSCAN29%20KIFC3%20SIVA1%20ZSCAN12%20FRS3%20EVI5%20CCNK%20KRT34%20ZNF18%20COPS2%20REL%20KRTAP1-1%20KRT31%20ANKRD1%20ZSCAN23%20TAX1BP1%20KRTAP1-3%20ZSCAN18%20ZNF483%20KRT35%20ZKSCAN4%20MAGOHB%20EHMT2%20MDFI%20KRTAP3-1%20FRMD8%20MID2%20LMO2%20DDX6%20DZIP3%20LMO1%20ZNF174%20ZNF444%20NEK6%20EWSR1%20CCDC85B%20FAM124A%20TCEB3B%20KRTAP4-12%20PDLIM7%20EMD%20KRTAP10-7%20KRTAP10-8%20KRTAP10-9%20RNPS1%20CCDC125%20HOMEZ%20MAB21L3%20ZNF709%20CEP70%20ZNF417%20DVL3%20ZNF837%20WDYHV1%20ZNF668%20CARD10%20KRTAP2-4%20PICK1&term=&significant=1&sort_by_structure=1&hierfiltering=&output=mini&custbg_file=&custbg=&user_thr=1.00&min_set_size=0&max_set_size=0&min_isect_size=0&prefix=AFFY_HUEX_1_0_ST_V2&threshold_algo=analytical&domain_size_type=annotated&aresolve=&advanced_options_on=0&sf_GO=on&sf_GO:BP=on&sf_GO:CC=on&sf_GO:MF=on"); 
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
     
        $output = curl_exec($ch); 

        curl_close($ch); 
        
        $out = "signf\tcorr. p-value\tterm ID\ttype\tgroup\tname and depth in group\r\n";
        preg_match('/^.*\r?\n#\r?\n((1\t.*\r?\n)*)#INFO/', $output, $matches, PREG_OFFSET_CAPTURE);
        
        $out_array = explode("\n",$matches[1][0]);
        
        
        $go_term_array = array();
        
        foreach($out_array as $single){
            
            
            if($single != ""){
            
                print $single;
                $single_array = explode("\t",$single);

                
                $go_term_array['p-value'] = $single_array[2];
                
                $go_term_array['GO_term_code'] = $single_array[8];
                
                $go_term_array['GO_term'] = $single_array[11];
            
            
            }

        }
        
        print_r($go_term_array);
        
?>