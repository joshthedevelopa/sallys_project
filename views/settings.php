<div id="main-content">
    <form>
    <div style="display:flex">
        <div style="flex: 5">
            <div class="card">
                <div class="card-header">Overview</div>
                <div class="card-body" id="overview">
                    <div class="row">
                        <div>
                            <h3>Name :</h3>
                            <h4 class="name">Joshua Tetteh</h4>
                        </div>
                        <div>
                            <h3>Contact :</h3>
                            <h4 class="contact">233 546 308 417</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <h3>Role / Permission :</h3>
                            <h4 class="role">Super Adminatrato</h4>
                        </div>
                        <div>
                            <h3>Account Status :</h3>
                            <h4 class="status">Active</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="card input-container" style="margin-right: 4px !important">
                            <div class="custom-input">
                                <div class="icon">
                                    <i class="fa fa-sm fa-user"></i>
                                </div>
                                <input name="firstname" placeholder="First Name" value="">
                            </div>
                        </div>
                        <div class="card input-container" style="margin-left: 4px !important">
                            <div class="custom-input">
                                <div class="icon">
                                    <i class="fa fa-sm fa-user"></i>
                                </div>
                                <input name="lastname" placeholder="Last Name" value="">
                            </div>
                        </div>
                    </div>

                    <div class="card input-container" style="margin-top: 0 !important;">
                        <div class="custom-input">
                            <div class="icon">
                                <i class="fa fa-sm fa-user"></i>
                            </div>
                            <input name="username" placeholder="Username" value= "">
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
        <div style="flex: 5">
            
            <div class="card">
                <div class="card-header">Account Password</div>
                <div class="card-body">

                    <div class="card input-container">
                        <div class="custom-input">
                            <div class="icon">
                                <i class="fa fa-sm fa-key"></i>
                            </div>
                            <input name="current_password" placeholder="Current Password">
                        </div>
                    </div>
                    <div style="height: 1px;"></div>
                    <div class="card input-container">
                        <div class="custom-input">
                            <div class="icon">
                                <i class="fa fa-sm fa-key"></i>
                            </div>
                            <input name="new_password" placeholder="New Password">
                        </div>
                    </div>
                    <div class="card input-container">
                        <div class="custom-input">
                            <div class="icon">
                                <i class="fa fa-sm fa-key"></i>
                            </div>
                            <input name="confirm_password" placeholder="Confirm Password">
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">Account Actions</div>
                <div class="card-body row-3">
                    <div class="btn btn-primary data-holder-action" action="update_admin" data="">Update Details</div>
                    <div class="btn btn-primary data-holder-action" action="update_password" data="">Update Password</div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>