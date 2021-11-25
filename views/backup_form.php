<div id="main-content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fa fa-dashboard"></i>
                <h2>Create A Backup</h2>
            </div>
        </div>
    </div>
    <div class="card">
        
        <div class="card-body">

            <form id="backup">
                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-database"></i>
                        </div>
                        <input name="name" placeholder="Name of Backup">
                    </div>
                </div>
    
                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-user"></i>
                        </div>
                        <select name="user">
                            <option value="">-- Select A User --</option>
                        </select>
                    </div>
                </div>

                <div class="card input-container">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-file"></i>
                        </div>
                        <input name="file" type="file">
                    </div>
                </div>
    
                <div class="card input-container input-container-textarea">
                    <div class="custom-input">
                        <div class="icon">
                            <i class="fa fa-sm fa-text"></i>
                        </div>
                        <textarea name="description" rows="7"></textarea>
                    </div>
                </div>

                <div class="btn btn-primary data-holder-action" action="create_backup" data="">Create</div>
            </form>
                

        </div>
    </div>
</div>