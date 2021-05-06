<?php
class Services extends MY_Controller{
    private $searchTables;
    private $labels;
    private $labelsColor;


    function __construct(){
        parent::__construct();

        $this->searchTables = [
            'esic_lawyers' => [
                'columns'=> ['slug','name','website','date_created as dateCreated', 'address_state as state','address_post_code as postCode'],
                'like'=> ['slug','name','website'],
                'label'=> 'Lawyers',
                'selectFilter'=>['State'=>'address_state','PostCode'=>'address_post_code']
            ],
            'esic_accelerators' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','Program_Summary as summary','logo','address_state as state','address_post_code as postCode'],
                'like'=> ['slug','name','website'],
                'label'=> 'Accelerators',
                'selectFilter' => ['State'=>'address_state','PostCode'=>'address_post_code']
            ],
            'esic_rndpartner' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','logo','banner', 'address_state as state', 'address_post_code as postCode'],
                'like'=> ['slug','name','website'],
                'label'=> 'R&D Partners',
                'selectFilter'=>['State'=>'address_state','PostCode'=>'address_post_code']
            ],
            'esic_rndconsultant' => [
                'columns'=> ['slug','name','website','date_created as dateCreated', 'address_state as state','address_post_code as postCode'],
                'like'=> ['slug','name','website'],
                'label'=> 'R&D Consultants',
                'selectFilter'=>['State'=>'address_state','PostCode'=>'address_post_code as postCode']
            ],
            'esic_grantconsultant' => [
                'columns'=> ['slug','name','website','date_created as dateCreated','address_state as state','address_post_code as postCode'],
                'like'=> ['slug','name','website'],
                'label'=> 'Grant Consultants',
                'selectFilter'=>['State'=>'address_state','PostCode'=>'address_post_code']
            ]
        ];
        //$this->labels = $this->_availableLabels();
        //$this->labels = $this->_getLabelsColor($this->searchTables);
        
    }
    public function AdminSetting(){
        if(isCurrentUserAdmin($this)){
            $this->data['labels'] = $this->_getLabelsColor($this->searchTables);
            $this->show_admin("services/setting",$this->data);
        }else{
             $this->show_front("NoPermissionAdmin",$this->data);
        }
    }
    public function Edit($id){
        if(isCurrentUserAdmin($this)){
            $where = array('id' => $id);
            $this->data['detail'] = $this->Common_model->select_fields_where('esic_listings','*',$where,true);
            $this->show_admin("services/edit",$this->data);
        }else{
             $this->show_front("NoPermissionAdmin",$this->data);
        }

    }
    public function EditSave(){
        if(isCurrentUserAdmin($this)){
            $id = $this->input->post('id');
            $color = $this->input->post('color');
            if(!empty($id)){
                $where = array('id' => $id);
                $updateData = array('color' => $color);
                $this->Common_model->update('esic_listings',$where,$updateData);
                $this->data['detail'] = $this->Common_model->select_fields_where('esic_listings','*',$where,true);
                $this->show_admin("services/edit",$this->data);
            }
        }else{
             $this->show_front("NoPermissionAdmin",$this->data);
        }
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
        $sessionArray = [
            'searchPostData' => $this->input->post(),
            'layout'         => $this->input->get('layout'),
            'startListIndex' => $startIndex
        ];
        $this->session->set_userdata($sessionArray);
        redirect(base_url('services/searchListing'));
    }

    public function fetchdata(){
        $startIndex = $this->session->userdata('startListIndex');
        $postData = $this->session->userdata('searchPostData');
        $this->session->unset_userdata('searchPostData');
        //If the Request if Changing Layout, Then Just Update the Layout for the User.
        if(!empty($postData)) $this->session->set_userdata('previousPostData', $postData);
        $layout = $this->session->userdata('layout');
        $this->session->unset_userdata('layout');
        if(!empty($layout)){
            $this->session->set_userdata('serviceSearchLayout',$layout);
        }

        if(empty($postData) && ($startIndex > 0 || !empty($layout)))
            $postData = $this->session->userdata('previousPostData');
        //We Need to Fetch all the records from the mentioned tables and columns.
        //I don't have time to keep efficiency of the search in-tact. Need to complete the feature. so i will be using multiple queries.
        //This work can be done by UNION, but CI does not support UNION, and will have to manually code for that to make our CI support UNION.
        //So i will go for the multiple queries in foreach. will fix this later when there is isssue of performance.
        //my current aim to finish the work asap, as this project is already been so late. SORRY.
        $filters = [];
        $searchKey = $postData['searchKey'];
        // split search key into pieces, so that we can search related listings
        $searchKeys = str_split($searchKey, 1);
        $filters['searchKey'] = $searchKey;
        $searchKey = strtolower($searchKey);


        if($postData){
            //As this is the POST Request. So First Of All Clear the Old Session for Filters. As we will save the new in the end.
            //If there is Post To This Page. Then Unset the Damn Values.
            $this->session->unset_userdata('advanceSearchFilters');
            //Now Get the Posted Values.
            $listingTypes = $postData['listingTypesSelect'];
            $recordsWithImages = $postData['recordsWithImages'];
            $filters['recordsWithImages'] = $recordsWithImages; //Send back to view after page load ;)

            //Sorting and Ordering Values in Post.
            $FilterSortBy = $postData['sortBy'];
            $FilterOrderBy = $postData['orderBy'];
            //Assign back to front the sorting and ordering.
            $filters['sortBy'] = $FilterSortBy;
            $filters['orderBy'] = $FilterOrderBy;

            //Address/State.
            $selectedPostCodes = $postData['postCodesSelect'];
            $selectedStates = $postData['stateSelect'];

            $filters['postCodesSelect'] = $selectedPostCodes;
            $filters['stateSelect'] = $selectedStates;

        }//End of If Post Function.
        else{
            //As this is not the POST request. So, Check If there are Any Filters Present for this User.
            //$advanceFilters = $this->session->userdata('serviceSearchFilters');
            $advanceFilters = '';
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

                $selectedPostCodes = $advanceFilters['postCodesSelect'];
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
        foreach($this->searchTables as $table=>$row){
            $labelsColor = $this->_getLabelColor($table);
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
                            if(!empty($where)){
                                $where.= ' OR ';
                            }
                            $where .= '(LOWER(`'.$column.'`) LIKE "%'.$key.'%")';
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
                    $results[$key]['color'] = $labelsColor;
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
        if(!empty($selectedPostCodes) || !empty($selectedStates)){

            //Array Map Returns me null, if no value found, where as array filter will skip the value if it does not exist. Array filter is like SQL query :)

            if(!empty($selectedPostCodes) and !empty($selectedStates)){
                $filteredValues = array_merge($selectedPostCodes,$selectedStates);
            }elseif(!empty($selectedPostCodes)){
                $filteredValues = $selectedPostCodes;
            }elseif(!empty($selectedStates)){
                $filteredValues = $selectedStates;
            }

            $mergedResults =  array_filter($mergedResults, function($subArray) use ($filteredValues){
                if(isset($subArray['postCode']) and !empty($subArray['postCode'])){
                    //This Means there is postCode Column Here.
                    //Now check weather the column value matches or not.
                    if(in_array($subArray['postCode'],$filteredValues) || in_array($subArray['state'],$filteredValues)){
                        return $subArray;
                    }
                }
                return false;
            });
        }

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
        $paginationConfig['base_url'] = base_url('services/search');
        $paginationConfig['total_rows'] = count($mergedResults);
        $paginationConfig['per_page'] = 20;

        //Need to work for BootStrap Style Pagination.
        /* This Application Must Be Used With BootStrap 3 *  */
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


        $data = array_slice($mergedResults,$startIndex,$paginationConfig['per_page']);
        $this->pagination->initialize($paginationConfig);
        $pagination =  $this->pagination->create_links();
        $filters['selectedListingTypes'] = $listingTypes;

        //Setup the Session.
        if($this->input->post()){
            //New Session should Only Set if the Request type is of POST.
            $this->session->set_userdata('serviceSearchFilters',$filters);
        }
        $this->_show($data,$pagination,$filters);
    }//End of Fetch Function

    private function _show($resultData,$pagination=null,$filters=null){
        $this->labels = $this->_getLabelsColor($this->searchTables);
        $selectors = [
            'postCodes' => $this->_getSelectedPostCodes(((isset($filters['postCodesSelect']) and !empty($filters['postCodesSelect']))?$filters['postCodesSelect']:NULL)),
            'states' => $this->_getStates(),
        ];

        //Get the Layout.
        $advanceSearchLayout = $this->session->userdata('serviceSearchLayout');
        if(!empty($advanceSearchLayout) and $advanceSearchLayout==='listview'){
            $searchLayout = 'listItemBox';
        }else{
            $searchLayout = 'gridItemBox';
        }

        $this->load->view('structure/header',$this->data);
        $this->load->view('services/services_search_main',['searchResults'=>$resultData,'pagination'=>$pagination,'labels' => $this->labels,'filters'=>$filters,'selectors'=>$selectors,'searchLayout'=>$searchLayout, 'labelsColor' => $this->labelsColor]);
        $this->load->view('structure/footer',$this->data);
    }

    public function updateServiceFilter(){
        $serviceType = $this->input->post('filterType');
        $service = $this->input->post('value');
        if(empty($serviceType)){
            return false;
        }

        //get the current session first.
        $advanceFilters = $this->session->userdata('serviceSearchFilters');
        $currentServiceTypes = $advanceFilters['selectedListingTypes'];
        if(empty($currentServiceTypes)){
            $currentServiceTypes = [];
        }
        switch($serviceType){
            case 'add':
                array_push($currentServiceTypes,$service);
                break;

            case 'remove':
                $currentServiceTypes = array_filter($currentServiceTypes,function($serviceFilter) use ($service){
                   if($serviceFilter != $service){
                       return $serviceFilter;
                   }
                });
                break;
        }

        //set back the session.
        $advanceFilters['selectedListingTypes'] = $currentServiceTypes;
        $this->session->set_userdata('serviceSearchFilters',$advanceFilters);
        redirect('services/search');
    }

//    public function GetPostCodes(){
//        $table = $this->postCodesTable;
//        $selectData = [
//            '
//            `id` as `ID`,
//             CONCAT(postcode) as `TEXT`
//            ',
//            false
//        ];
    public function GetPostCodes(){ // services controller
        $table = $this->postCodesTable;
        $selectData = [
            '
            `id` as `ID`,
             `postcode` as `TEXT`,
             `place_name` as `Place_Name` 
            ',
            false
        ];



      //  CONCAT(postcode," - ",place_name) as `TEXT`
//        $selectData = "ID, Title AS TEXT";
        $search = $this->input->get('q');
        $page = $this->input->get('page');
        $state = $this->input->get('state');
        $where = 'state_code = "'.$state.'"';

        if(!empty($page) and is_numeric($page)){
            $limit = [((intval($page)-1)*30),30];
        }else{
            $limit = [30,0];
            $limit = '';
        }

        //Count Items
        $selectDataCount = ['COUNT(1) AS TotalFound',false];
        if(isset($search) && !empty($search)){
            $where .= " 
            AND 
          (LOWER(place_name) LIKE '%".strtolower($search)."%' 
          OR LOWER(postcode) LIKE '%".strtolower($search)."%')";

            $postCodes = $this->Common_model->select_fields_where($table,$selectData,$where,false,'','','','','',true, $limit);
            $postCodesCount = $this->Common_model->select_fields_where($table,$selectDataCount,$where,true,'','','','','',false);

        }else{
            if(!empty($where)){
                $postCodes = $this->Common_model->select_fields_where($table,$selectData,$where,false,'','','','','',true, $limit);
                $postCodesCount = $this->Common_model->select_fields_where($table,$selectDataCount,$where,true,'','','','','',false);
            }else{
                $postCodes = $this->Common_model->select_fields($table,$selectData,false,'','',true, $limit);
                $postCodesCount = $this->Common_model->select_fields($table,$selectDataCount,true,'','',false);
            }
        }

        $returnedData = [
            'total_count' => $postCodesCount->TotalFound
        ];
        if(empty($postCodes)){
            $emptyArray =
                array(
                    'ID' => 0,
                    'TEXT' => "No Record Found"
                );
            $returnedData['items'][0] = $emptyArray;
            print json_encode($returnedData);
            return;
        }
        $returnedData['items'] = $postCodes;
        print json_encode($returnedData);
    }
    private function _availableLabels(){
        return array_column($this->searchTables,'label');
    }
    private function _getLabelsColor($tableArray){

        $returnArray = array();
        foreach ($tableArray as $key => $value) {
            $where = array('tableName' => $key);
            $result = $this->Common_model->select_fields_where('esic_listings','id,color',$where,true);
            if(!empty($result) && !empty($result->color)){
                $array = array(
                    'id' => $result->id,
                    'color' => $result->color,
                    'label' => $value['label'],
                    'tableName' => $key
                );
                array_push($returnArray, $array);
            }
        }
        return $returnArray;
    }
    private function _getLabelColor($table){
        $where = array('tableName' => $table);
        $result = $this->Common_model->select_fields_where('esic_listings','color',$where,true);
            if(!empty($result) && !empty($result->color)){
                return $result->color;
            }
        return false;
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
}
