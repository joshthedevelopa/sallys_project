<div id="main-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-dashboard"></i>
                <h2>Add A User</h2>
            </div>
        </div>
    </div>
    <div class="card">
        
        <div class="card-body">

            <form id="user">
                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-database"></i>
                        </div>
                        <input name="name" placeholder="Name of User">
                    </div>
                </div>

                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-database"></i>
                        </div>
                        <input name="contact" placeholder="Contact Number of User">
                    </div>
                </div>


                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-database"></i>
                        </div>
                        <input name="location" placeholder="Location of User">
                    </div>
                </div>
    
                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-user"></i>
                        </div>
                        <select name="backup_quota">
                            <option value="">-- Select Backup Quota --</option>
                            <option value="1024">1 GB</option>
                            <option value="10024">10 GB</option>
                            <option value="100024">100 GB</option>
                        </select>
                    </div>
                </div>

                <div class="btn btn-primary data-holder-action" action="create_user" data="">Create</div>
            </form>
                

        </div>
    </div>
</div>