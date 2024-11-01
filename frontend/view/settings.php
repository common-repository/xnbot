
<div id="form-container" class="col-xs-12">
    <div class="title">
        <h1 class="uppercase"><b>XnBot</b> settings</h1>
        <br/>
    </div>
    <div class="max-w-700">    

          <!-- Stack the columns on mobile by making one full-width and the other half-width -->


            <div class="row"> 
                    <div class="col-xs-12" align="left"><h3>API KEY</h3></div>
                    <div class="col-xs-12 col-md-9"><p align="left" style="text-transfrom:uppercase;"><?php echo $access_api_key; ?></p></div>
            </div> 


            <div class="row">
                <div class="col-xs-12" align="left"><h3>Chat window integration:  <?php echo (isset($status) && intVal($status) == 1 )? 'ACTIVE' : 'INACTIVE' ; ?></h3></div>
                <div class="col-xs-12 col-md-9"><p align="justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor nisl nec ante tincidunt, eu facilisis enim egestas. </p></div>
                <div class="col-xs-12 col-md-3 actions_div">
                <form method="post">  
                    <div class="form-group submit_form_container" align="right">
                        <?php if($status == '0' || $status == ""){  ?>
                            <button type="submit" name="xnbot_status" value="1" class="btn btn-md btn-success">Activate</button>
                        <?php }else{ ?>
                           <button type="submit" name="xnbot_status" value="0" class="btn btn-md btn-danger">Inactivate</button>
                        <?php } ?>
                    </div>
                </form>
                
                 </div>
            </div>

            <div class="row">
                <form method="post" > 
                    <div class="col-xs-12" align="left"><h3>Script manual update</h3></div>
                    <div class="col-xs-12 col-md-9"><p align="justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor nisl nec ante tincidunt, eu facilisis enim egestas. </p></div>
                    <div class="col-xs-12 col-md-3 actions_div"  align="right"> <button name="download_script" value="1" class="btn btn-md btn-default">Update Script</button></div>
                </form>
            </div> 
            
            <div class="row">
                <?php if(isset($plan) && !empty($plan)){ ?>
                    <div class="col-xs-12" align="left"><h3>Your plan</h3></div>
                    <div class="col-xs-12 col-md-9">
                    <p align="justify" style="font-size:15px; margin-bottom:0px !important;"><b><?php echo $plan->name; ?></b></p>
                    <p align="justify"><b><?php echo $plan->recycle_interactions; ?> interactions /month.</b></p></div>
                    <div class="col-xs-12 col-md-3 actions_div" align="right" > <a href="https://admin.xnbot.io/settings#subscription" class="btn btn-md btn-default">Update Account</a> </div>
                <?php } ?>
            </div>

            <div class="row">
               
                <div class="col-xs-12 col-md-12"><h3>Chat Interactions</h3><p align="left"><div class="interaction-box  <?php echo (isset($interactions->state) && $interactions->state != "" )? $interactions->state  : "" ;  ?>"
                 align="center"><?php echo  $interactions->current_recycle_interactions ?> - <?php echo  $interactions->current_interactions ?></div> </p></div>
        
            </div>
    </div>

    <div class="col-xs-12">    
        <hr></hr>
        <form method="post">  
            <div class="form-group submit_form_container" align="left">
                <?php submit_button( 'Disconnect XnBot', 'primary', 'xnbot_disconnect'  ); ?>
            </div>
        </form>
    </div>
</div>