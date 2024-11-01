<div id="form-container" class="col-xs-12">
    <div class="title">
        <h1 class="uppercase">Welcome to <b>XnBot</b> plugin page.</h1>
    </div>

    <div class="form">
    <form method="post" action="options.php">
            <?php settings_fields( 'xnbot-plugin-settings-group' ); ?>
            <?php do_settings_sections( 'xnbot-plugin-settings-group' ); ?>
            
            <br><br><br>
            <div class="form-group" align="left">
                <h3 for="exampleInputEmail1">Activate XnBot</h3>
                <small>Log in or sign up now.</small><br/><br/>
                <a target="_blank" href="https://admin.xnbot.io/register/wp" class="jump_parent_site"> Get API key</a>
            </div>

            <hr></hr>
            <div class="form-group" align="left">
                <h3 for="exampleInputEmail1">Enter an API key</h3>
                <small>Already have your key? Enter it here. (What is an API key?)</small><br/><br/>
                <input type="text" class="form-control" name="xnbot_api_key_token" id="" placeholder="KEY" value="<?php echo esc_attr( get_option('xnbot_api_key_token') ); ?>" >
            </div>

            <hr></hr>
            <div class="form-group submit_form_container" align="left">
                <?php submit_button( 'Connect with API key' ); ?>
            </div>

        </form>
    </div>
</div>