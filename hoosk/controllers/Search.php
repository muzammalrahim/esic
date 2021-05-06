<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {

    private $searchTables;
    private $labels;

    function __construct(){
        parent::__construct();

        $this->searchTables = [
            'esic' => [
                'columns'=> ['slug','name','website','date_created as dateCreated', 'logo','banner','short_description as summary', 'address_state as state','address','address_post_code','ranking_score' ],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'], //d
                'label'=> 'Esic',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],
            /*'esic_investors' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','address','address_state as state'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'],
                'label'=> 'Investor',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],*/
            'esic_lawyers' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','short_description as summary', 'address_state as state','address','logo','banner','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'], //d
                'label'=> 'Lawyer',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],
            'esic_accelerators' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','Program_Summary as summary','logo','banner','address','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'], // d
                'label'=> 'Accelerators',
                'selectFilter' => ['Address'=>'address']
            ],
            'esic_rndpartner' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','logo','banner','Program_Summary as summary', 'address_state as state', 'address','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'],  //d
                'label'=> 'R&D Partners',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],
            'esic_rndconsultant' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','short_description as summary', 'address_state as state','address','logo','banner','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'],//d
                'label'=> 'R&D Consultant',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],
            'esic_taxadvisors' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','short_description as summary', 'address_state as state','address','logo','banner','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'], //d
                'label'=> 'Tax Advisers',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ],
            'esic_grantconsultant' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','short_description as summary','address_state as state','address','logo','banner','address_post_code','ranking_score'],
                'like'=> ['slug','name','website'],
                'postcode'=> ['address_post_code'], //d
                'label'=> 'GrantConsultant',
                'selectFilter'=>['State'=>'address_state','Address'=>'address']
            ]
            /*
            'esic_institution' => [
                'columns'=> ['slug','institution as name','website','date_created as dateCreated','logo as logo', 'address'],
                'like'=> ['slug','institution','website'],
                'label'=> 'Institution',
                'selectFilter'=>['Address'=>'address']
            ],
            'esic_acceleration' => [
                'columns'=>['slug','Member as name','Web_Address as website','date_created as dateCreated', 'short_description as summary','logo as logo','Project_Location as address','State_Territory as state'],
                'like'=>['slug','Member','Web_Address'],
                'postcode'=> ['postal_code'],
                'label'=> 'Acceleration',
                'selectFilter' => ['State'=>'State_Territory','Address'=>'Project_Location']
            ],*/
        ];
        $this->labels = $this->_availableLabels();
    }

    public function fetch($startIndex=0){
        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
            $urlPartsArray = explode('/', $_SERVER['HTTP_REFERER']);
            if(is_array($urlPartsArray) && !empty($urlPartsArray)){
                $urlLastPart = end($urlPartsArray);
                if(empty($this->input->post('searchKey')) && ( empty($urlLastPart) || $urlLastPart == 'home')) {
                    redirect(base_url('esic'));
                }
            }
        }
        $this->session->set_userdata('searchPostData', $this->input->post());
        redirect(base_url('searchListing'));
    }
    public function fetchdata(){
        if(!empty($this->input->post('searchKey')) || !empty($this->input->post('listingTypesSelect')) || !empty($this->input->post('listingTypesSelect')) || !empty($this->input->post('stateSelect')) ){
            $this->session->set_userdata('searchPostData', $this->input->post());
        }
        $postData = $this->session->userdata('searchPostData');
        //We Need to Fetch all the records from the mentioned tables and columns.
        //I don't have time to keep efficiency of the search in-tact. Need to complete the feature. so i will be using multiple queries.
        //This work can be done by UNION, but CI does not support UNION, and will have to manually code for that to make our CI support UNION.
        //So i will go for the multiple queries in foreach. will fix this later when there is isssue of performance.
        //my current aim to finish the work asap, as this project is already been so late. SORRY.
        $filters = [];
        $searchKey = $postData['searchKey'];
        // split search key into pieces, so that we can search related listings
        $searchKeys = str_split($searchKey, 3);
        $filters['searchKey'] = $searchKey;
        $searchKey = strtolower($searchKey);
        if($postData){
            //As this is the POST Request. So First Of All Clear the Old Session for Filters. As we will save the new in the end.
            //If there is Post To This Page. Then Unset the Damn Values.
           // $this->session->unset_userdata('advanceSearchFilters');
            //Now Get the Posted Values.
            $listingTypes =  $postData['listingTypesSelect'];
            $recordsWithImages =  $postData['recordsWithImages'];
            $filters['recordsWithImages'] = $recordsWithImages; //Send back to view after page load ;)

            //Sorting and Ordering Values in Post.
            $FilterSortBy       =  $postData['sortBy'];
            $FilterOrderBy      =  $postData['orderBy'];
            //Assign back to front the sorting and ordering.
            $filters['sortBy']  = $FilterSortBy;
            $filters['orderBy'] = $FilterOrderBy;

            //Address/State.
            $selectedAddresses =  $postData['addressSelect'];
            $selectedStates    =  $postData['stateSelect'];

            $filters['addressSelect'] = $selectedAddresses;
            $filters['stateSelect']   = $selectedStates;

        }//End of If Post Function.
        else{
            //As this is not the POST request. So, Check If there are Any Filters Present for this User.
            $advanceFilters = $this->session->userdata('advanceSearchFilters');
            if(!empty($advanceFilters)){
                //Means Filters Do Exist.
                $filters = $advanceFilters; //For Posting to Front Page.
                //Now For Search Criteria.
                $recordsWithImages = $advanceFilters['recordsWithImages'];
                $searchKey = $advanceFilters['searchKey'];
                $listingTypes = $advanceFilters['selectedListingTypes'];

                //Sorting and Filtering.
                $FilterSortBy = $advanceFilters['sortBy'];
                $FilterOrderBy = $advanceFilters['orderBy'];

                $selectedAddresses = $advanceFilters['addressSelect'];
                $selectedStates = $advanceFilters['stateSelect'];
            }
        }

        //Filter the Listing Types if there are Any..
        if(isset($listingTypes)){
            $this->_filterListingTypes($listingTypes);
        }
        $mergedResults = [];
        $relatedListing = true;
        //Fetch And Merge Records
        $popup_warning = false;
        foreach($this->searchTables as $table=>$row){
            $columnsString = implode(',',$row['columns']);
            $selectData = [$columnsString,false];

            //work for like, so to fetch only those records that match the like.
            $whereMust = 'Publish = 1 AND (';
            $where = '';
            $countFilters = 0;
            foreach($row['like'] as $column){
                    if(!empty($where)){
                        $where.= ' OR ';
                    }
                $where .= '(LOWER(`'.$column.'`) LIKE "%'.$searchKey.'%")';
            }
            $where = $whereMust.$where.')';
            $results = $this->Common_model->select_fields_where($table,$selectData,$where,false,'','','','','',true);
            // here check if nothing found, then do search for related listings

            if(!is_array($results) || empty($results)){ 
                $where = '';
                foreach($row['like'] as $column){
                    foreach($searchKeys as $key) {
                        if(strlen($key)>2){ // chunk with length greater than two will be match
                            if(!empty($where)){
                                $where.= ' OR ';
                            }
                            $where .= '(LOWER(`'.$column.'`) LIKE "%'.$key.'%")';
                        }
                    }
                }
                if(empty($where)) $where = '`id` >0';
                    $where = $whereMust.$where.')';
                $results = $this->Common_model->select_fields_where($table,$selectData,$where,false,'','','','','',true);
            } else {
                $relatedListing = false;
            } 
            if(!empty($results)){
                foreach($results as $key=>$resultRow){
                    $results[$key]['type'] = $row['label'];
                }
                $mergedResults = array_merge($mergedResults,$results);
            }
        }//End of Foreach
        if($relatedListing){
            $this->session->set_flashdata('related_prod', 'Related Search (not exact matches)');
        }
        if(isset($recordsWithImages) and $recordsWithImages === 'true'){
            $mergedResults = $this->_recordsWithImages($mergedResults);
        }
        //Now Find Those Records whose Address/State Matches.
       /* if(!empty($selectedAddresses) || !empty($selectedStates)){

            //Array Map Returns me null, if no value found, where as array filter will skip the value if it does not exist. Array filter is like SQL query :)
            /*$mergedResults =  array_map(function($subArray) use ($selectedAddresses){
                        if(isset($subArray['address']) and !empty($subArray['address'])){
                            //This Means there is Address Column Here.
                            //Now check weather the column value matches or not.
                            if(in_array($subArray['address'],$selectedAddresses)){
                                return $subArray;
                            }
                        }
                        return false;
            },$mergedResults);

            if(!empty($selectedAddresses) and !empty($selectedStates)){
                $filteredValues = array_merge($selectedAddresses,$selectedStates);
            }elseif(!empty($selectedAddresses)){
                $filteredValues = $selectedAddresses;
            }elseif(!empty($selectedStates)){
                $filteredValues = $selectedStates;
            }

            $mergedResults =  array_filter($mergedResults, function($subArray) use ($filteredValues){
                        if(isset($subArray['address']) and !empty($subArray['address'])){
                            //This Means there is Address Column Here.
                            //Now check weather the column value matches or not.
                            if(in_array($subArray['address'],$filteredValues) || in_array($subArray['state'],$filteredValues)){
                                return $subArray;
                            }
                        }
                        return false;
            });
        }
       */

        //Do Sorting and Order if only is requested.
        if(!empty($FilterSortBy) || !empty($FilterOrderBy)){
            //Seems like we will have to process this query.

            //Get the Sort.
            switch ($FilterSortBy){
                case 'Name':
                    $sortBy = 'name';
                    break;
                case 'DateCreated':
                    $sortBy = 'dateCreated'.':::DATE';
                    break;
                default:
                    $sortBy = 'name';
            }
            switch ($FilterOrderBy){
                case 'ASC':
                    $orderBy = SORT_ASC;
                    break;
                case 'DESC':
                    $orderBy = SORT_DESC;
                    break;
                default:
                    $orderBy = SORT_ASC;
            }
            $mergedResults = array_orderBy($mergedResults,$sortBy,$orderBy);
        }

        // Pagination Work
        $this->load->library('pagination');
        $paginationConfig['base_url'] = base_url('searchListing');
        $paginationConfig['total_rows'] = count($mergedResults);
        $paginationConfig['per_page'] = 12;
        $paginationConfig['full_tag_open'] = "<ul class='pagination'>";
        $paginationConfig['full_tag_close'] ="</ul>";
        $paginationConfig['num_tag_open'] = '<li>';
        $paginationConfig['num_tag_close'] = '</li>';
        $paginationConfig['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $paginationConfig['cur_tag_close'] = "</a></li>";
        $paginationConfig['next_tag_open'] = "<li>";
        $paginationConfig['next_tagl_close'] = "</li>";
        $paginationConfig['prev_tag_open'] = "<li>";
        $paginationConfig['prev_tagl_close'] = "</li>";
        $paginationConfig['first_tag_open'] = "<li>";
        $paginationConfig['first_tagl_close'] = "</li>";
        $paginationConfig['last_tag_open'] = "<li>";
        $paginationConfig['last_tagl_close'] = "</li>";
        $paginationConfig['use_page_numbers'] = TRUE;
        $startIndex=0;
        $lasturi = $this->uri->segment_array();
        $record_num = end($lasturi);
        if(is_numeric($record_num)){
            $startIndex = $record_num*$paginationConfig['per_page']-$paginationConfig['per_page'];
        }
        $data = array_slice($mergedResults,$startIndex,$paginationConfig['per_page']);
        $this->pagination->initialize($paginationConfig);
        $pagination =  $this->pagination->create_links();
        $filters['selectedListingTypes'] = $listingTypes;
        //Setup the Session.
        if($this->input->post()){
            //New Session should Only Set if the Request type is of POST.
            $this->session->set_userdata('advanceSearchFilters',$filters);
        }
        $this->_show($data,$pagination,$filters);
    }//End of Fetch Function
    private function _show($resultData,$pagination=null,$filters=null){
        $selectors = [
            'addresses' => $this->_getAddresses(),
            'states' => $this->_getStates(),
        ];
        $this->load->view('structure/header',$this->data);
        $this->load->view('search/main',['searchResults'=>$resultData,'pagination'=>$pagination,'labels' => $this->labels,'filters'=>$filters,'selectors'=>$selectors]);
        $this->load->view('structure/footer',$this->data);
    }
    private function _maxSubArrayItems(){
        $maxSubArraySize = 0;
        if(!empty($this->searchTables)){
            foreach($this->searchTables as $key=>$array){
                $totalValues = count($array);
                if($maxSubArraySize < $totalValues){
                    $maxSubArraySize = $totalValues;
                }
            }
        }
        return $maxSubArraySize;
    }
    private function _availableLabels(){
        return array_column($this->searchTables,'label');
    }
    private function _getAddresses(){
        $allAddresses = [];
        foreach($this->searchTables as $table=>$details){
            //If No SelectFilter Index Is There. Means Filters from this Table will not be listed in select.
            if(isset($details['selectFilter']) and !empty($details['selectFilter']['Address'])){
                $selectData = $details['selectFilter']['Address'];
                $addresses = $this->Common_model->select_fields($table,$selectData.' as Address',false,$selectData,'',true);
                if(!empty($addresses)){
                    $allAddresses = array_merge($allAddresses,$addresses);
                }
            }//End of If Statement.
        }
        return array_unique(array_column($allAddresses, 'Address'));
    }
    private function _getStatesSearch(){
        $allStates = [];
        foreach($this->searchTables as $table=>$details){
            //If No SelectFilter Index Is There. Means Filters from this Table will not be listed in select.
            if(isset($details['selectFilter']) and !empty($details['selectFilter']['State'])){
                $selectData = $details['selectFilter']['State'];
                $states = $this->Common_model->select_fields($table,$selectData.' as State',false,$selectData,'',true);
                if(!empty($states)){
                    $allStates = array_merge($allStates,$states);
                }
            }
        }
        return array_unique(array_column($allStates, 'State'));
    }
    private function _recordsWithImages($records){
        //Unset Records That Do Not Have Any Images.

        if(!empty($records)){
            foreach ($records as $index=>$record){
                $dumpRecord = false;
                if(!isset($record['logo']) || empty('logo')){
                    //Now Check if Banner is Also empty.
                    if(!isset($record['banner']) || empty('banner')){
                        //Banner Image Also Not Present. To Implement Filter. We Now will have to Unset the Record.
                        unset($records[$index]);
                        $dumpRecord = true;
                    }
                }

                if($dumpRecord!==true){
                    //Means Record was not unset. and there was some value present there.
                    //Check Weather the record value has related image on server.
                    $fileExistsLogo = file_exists($record['logo']);
                    $fileExistsBanner = file_exists($record['banner']);

                    if(!$fileExistsLogo and !$fileExistsBanner){
                        //Unset Again as the Record Present has no corresponding image on server.
                        unset($records[$index]);
                    }

                }
            }
        }
        return $records;
    }
    private function _filterListingTypes($listingTypes){
        if(!empty($listingTypes)){
            $listingTypes = array_map('strtolower',$listingTypes);
            foreach($this->searchTables as $table=>$details){
                if(!in_array(strtolower($details['label']),$listingTypes)){
                    unset($this->searchTables[$table]);
                }
            }//End of Foreach Statement
        }//End of If Not Empty Listing Types.
    }
    public function search_local_providers($pam=NULL){
        $postcode     = $this->input->post('local_postcode');
        $listingTypes = $this->input->post('listingTypesSelect');
        if(!empty($postcode) && isset($postcode)){
            $this->session->set_userdata('postcodes',$postcode);
            $this->session->set_userdata('listingTypes',$listingTypes);
        }else{
            $postcode     = $this->session->userdata('postcodes');
            $listingTypes = $this->session->userdata('listingTypes');
        }
        $mergedResults = array();
        if(isset($listingTypes)){
            $this->_filterListingTypes($listingTypes);
        }
        foreach($this->searchTables as $table=>$row){  // get data by exact post code match
            $columnsString = implode(',',$row['columns']);
            $selectData = [$columnsString,false]; // Post code column and points colum
            $postcodecolumn = $row["postcode"][0];
            $where = array("Publish" => '1');
            if(!empty($postcodecolumn) && !empty($postcode)) {
                $where = array( "Publish" => '1',
                    $postcodecolumn => $postcode,
                );
            }
            $order_by = array('ranking_score','DESC');
            $results  = $this->Common_model->select_fields_where($table, $selectData, $where, false, '', '', '','',$order_by, true ,'');
            if(!empty($results)){
                foreach($results as $key=>$resultRow){
                    $results[$key]['type'] = $row['label'];
                }
                $mergedResults = array_merge((array)$results, $mergedResults);
            }
        }//End of Foreach
        if(empty($mergedResults)) {
            $mergedResults = $this->get_listing_by_postcode($postcodeinc= 0,$postcode);
        }
        usort($mergedResults,array($this,'ranking_score')); // function name ranking_score
        if(isset($recordsWithImages) and $recordsWithImages === 'true'){
            $mergedResults = $this->_recordsWithImages($mergedResults);
        }
        //Now Find Those Records whose Address/State Matches.
        if(!empty($selectedAddresses) || !empty($selectedStates)){
            if(!empty($selectedAddresses) and !empty($selectedStates)){
                $filteredValues = array_merge($selectedAddresses,$selectedStates);
            }elseif(!empty($selectedAddresses)){
                $filteredValues = $selectedAddresses;
            }elseif(!empty($selectedStates)){
                $filteredValues = $selectedStates;
            }
            $mergedResults =  array_filter($mergedResults, function($subArray) use ($filteredValues){
                if(isset($subArray['address']) and !empty($subArray['address'])){
                    //This Means there is Address Column Here.
                    //Now check weather the column value matches or not.
                    if(in_array($subArray['address'],$filteredValues) || in_array($subArray['state'],$filteredValues)){
                        return $subArray;
                    }
                }
                return false;
            });
        }
        $this->load->library('pagination');
        $paginationConfig['base_url']        = base_url('search_local_providers');
        $paginationConfig['total_rows']      = count($mergedResults);
        $paginationConfig['per_page']        = 12;
        $paginationConfig['full_tag_open']   = "<ul class='pagination'>";
        $paginationConfig['full_tag_close']  = "</ul>";
        $paginationConfig['num_tag_open']    = '<li>';
        $paginationConfig['num_tag_close']   = '</li>';
        $paginationConfig['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $paginationConfig['cur_tag_close']   = "</a></li>";
        $paginationConfig['next_tag_open']   = "<li>";
        $paginationConfig['next_tagl_close'] = "</li>";
        $paginationConfig['prev_tag_open']   = "<li>";
        $paginationConfig['prev_tagl_close'] = "</li>";
        $paginationConfig['first_tag_open']  = "<li>";
        $paginationConfig['first_tagl_close']= "</li>";
        $paginationConfig['last_tag_open']   = "<li>";
        $paginationConfig['last_tagl_close'] = "</li>";
        $paginationConfig['use_page_numbers'] = TRUE;
        $startIndex=0;
        $lasturi = $this->uri->segment_array();
        $record_num = end($lasturi);
        if(is_numeric($record_num)){
            $startIndex = $record_num*$paginationConfig['per_page']-$paginationConfig['per_page'];
        }
        $data = array_slice($mergedResults,$startIndex,$paginationConfig['per_page']);
        $this->pagination->initialize($paginationConfig);
        $pagination =  $this->pagination->create_links();
        $filters['selectedListingTypes'] = $listingTypes;
        //Setup the Session.
        if($this->input->post()){
            //New Session should Only Set if the Request type is of POST.
            $this->session->set_userdata('advanceSearchFilters',$filters);
        }
        $this->_show_local_providers($data,$pagination,$filters);
    }
    private function _show_local_providers($resultData,$pagination=null,$filters=null){
        $selectors = [
            'addresses' => $this->_getAddresses(),
            'states'    => $this->_getStates(),
        ];
        $this->load->view('structure/header',$this->data);
        $this->load->view('search/local_providers',['searchResults'=>$resultData,'pagination'=>$pagination,'labels' => $this->labels,'filters'=>$filters,'selectors'=>$selectors]);
        $this->load->view('structure/footer',$this->data);
    }

    private function ranking_score($item1,$item2) // sort Array by Ranking Score
    {
        if ($item1['ranking_score'] == $item2['ranking_score']) return 0;
        return ($item1['ranking_score'] < $item2['ranking_score']) ? 1 : -1;
    }
    private function get_listing_by_postcode($postcodeinc,$postcode) {
        // for empty results get listing by postcode prefix
        $mergedResults = array();
        foreach($this->searchTables as $table=>$row){
            $columnsString = implode(',',$row['columns']);
            $selectData = [$columnsString,false]; // Post code column and points colum
            $postcodecolumn = $row["postcode"][0];
            $order_by = array('ranking_score','DESC');
            if(!empty($postcodecolumn) && !empty($postcode)) {
               $postcode =   $postcodeinc !=0 ? $postcodeinc : substr($postcode,0,1);
                $whereMust = 'Publish = 1 AND (';
                $where  = ' `'.$postcodecolumn.'` LIKE "'.$postcode.'%" ';
                $where  =  $whereMust.$where.')';
            }
            $results  = $this->Common_model->select_fields_where($table, $selectData, $where, false, '', '', '','',$order_by, true ,'');

            if(!empty($results)){
                foreach($results as $key=>$resultRow){
                    $results[$key]['type'] = $row['label'];
                }
                $mergedResults = array_merge((array)$results, $mergedResults);
            }
        }//End of Foreach
        if(empty($mergedResults)){
            static $postcodeinc;
            $postcodeinc = $postcode + 1;
            if($postcodeinc < 10 ){
                return $this->get_listing_by_postcode($postcodeinc,$postcode);
            }else{
                return array();
            }
        }
        return $mergedResults=$mergedResults;

    }
}
