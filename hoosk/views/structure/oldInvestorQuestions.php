      <div id="form-questions">
          <fieldset>
              <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-12 col-md-6">
                     <p>Are you following an existing ESIC on our Directory ?</p>
                  </div>
                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                    <input type="radio" class="minimal" name="follow_ESIC" value="1"> Yes
                  </div>
                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                    <input type="radio" class="minimal" name="follow_ESIC" value="0" checked="checked"> NO
                  </div>
                  <?php if(isset($EsicList) && !empty($EsicList)){ ?>
                  <div id="esiccompanies-select-box" class="col-blocks col-xs-12 col-sm-6 col-md-4">
                        <select id="esiccompanies" name="esiccompanies[]" class="form-control js-example-basic-multiple select2-active" multiple data-placeholder="Select" placeholder="Select">
                          <!--option value="">Select</option-->
                          <option value="all" >All</option>
                          <?php foreach ($EsicList as $key => $value) { ?>
                            <option value="<?= $value->id; ?>" ><?= $value->name; ?></option>
                          <?php } ?>
                        </select>
                  </div>
                  <?php } ?>
              </div>
          </fieldset>
          <fieldset>
                <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                    <p>Do you plan to hold your investment for more than 12 months  
                        <span data-toggle="tooltip" title="If you purchase newly issued shares in a qualifying ESIC and hold them for 12 months, you will have a CGT exemption for up to 10 years when you sell your investment.">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                        </span>
                    </p>
                  </div>
                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                    <input type="radio" class="minimal" name="hold_investment" value="1"> Yes
                  </div>
                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                    <input type="radio" class="minimal" name="hold_investment" value="0" checked="checked"> NO
                  </div>
                </div>
          </fieldset>
          <fieldset>
                <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                    <p>Are you an affiliate of the ESIC?</p>
                  </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                      <input type="radio" class="minimal" name="affiliate_ESIC" value="1"> Yes
                    </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                      <input type="radio" class="minimal" name="affiliate_ESIC" value="0" checked="checked"> NO
                    </div> 
                </div>         
          </fieldset>
          <fieldset>
                <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                    <p>Do you own 30% or more of the equity interests of the ESIC or entities connected with the ESIC?</p>
                  </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                      <input type="radio" class="minimal" name="ent_con_ESIC" value="1"> Yes
                    </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                      <input type="radio" class="minimal" name="ent_con_ESIC" value="0" checked="checked"> NO
                    </div>
                </div>         
          </fieldset>
          <fieldset>
                <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                    <p>Are you a 'widely held company' or a 100% subsidiary of a widely held company?</p>
                  </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                       <input type="radio" class="minimal" name="widely_held_company" value="1"> Yes
                    </div>
                    <div class="col-blocks col-xs-3 col-sm-2 col-md-1">
                      <input type="radio" class="minimal" name="widely_held_company" value="0" checked="checked"> NO
                    </div>
                </div>         
          </fieldset>
          <fieldset>
                <div class="form-group bg-shaded clearfix">
                    <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                      <p>Which of the following best describes your experience in ESIC investment so far?</p>
                    </div>
                    <div class="col-blocks col-xs-12 col-sm-6 col-md-6" >
                      <select class="noselect2" name="esic_experience" style="width:95%;">
                        <option value="">Select</option>
                        <option value="1">I did NOT claim a tax offset for an ESIC investment last year</option>
                        <option value="2">I claimed a tax offset for an ESIC investment last year but DO NOT plan to carry it forward to this year</option>
                        <option value="3">I claimed a tax offset for an ESIC investment last year and DO plan to carry it forward to this year</option>
                      </select>
                    </div>
                </div>         
          </fieldset>               
      </div>