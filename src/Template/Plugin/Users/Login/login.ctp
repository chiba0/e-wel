<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="pull-right box-tools mt20">     
                <a href="/users/login/?lang=en" class="btn btn-primary btn-sm daterange pull-right" >中文</a>
                <a href="/users/login/?lang=jp" class="btn btn-primary btn-sm pull-right mr-5" >日本語</a>
            </div>  

            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <?= $this->Flash->render('login') ?>
                    <form role="form" action="<?=D_HOME_PATH?>users/login" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="userID" name="login_id" type="text" value="igate" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" value="9021INg" class="form-control" placeholder="password" >
                            </div>
                            
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" name="login" value="Login" class="btn btn-lg btn-success btn-block" /> 
                            
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="panel box box-primary">
                <div class="box-header">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <?=__("login_text1")?>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                        <?=__("login_message1")?><br />
                        <?=__("login_message2")?><br />
                        <ul>
                            <li><?=__("login_message3")?></li>
                            <li><?=__("login_message4")?></li>
                            <li><?=__("login_message5")?></li>
                            <li><?=__("login_message6")?></li>
                            <li><?=__("login_message7")?></li>
                            <li><?=__("login_message8")?></li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="panel box box-danger">
                <div class="box-header">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <?=__("login_text2")?>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                        <?=__("login_message3")?><br />
                        <?=__("login_message4")?><br />
                        <?=__("login_message5")?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
