    <div id="main-content">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa fa-dashboard"></i>
                    <h2>Customer</h2>
                </div>
                <!-- <div class="card-action">
                            <ul>
                                <li> <i class="fa fa-user"></i>
                                    <h4>Add Customer</h4>
                                </li>
                                <li>
                                    <i class="fa fa-user"></i>
                                    <h4>Upload</h4>
                                </li>
                            </ul>
                        </div> -->
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa fa-dashboard"></i>
                    <h3>List of customers</h3>
                </div>
                <div class="card-action">
                    <ul>
                        <li class="navigation-btn" target="user_form"> <i class="fa fa-sm fa-user-plus"></i>
                            <h5>Add Customer</h5>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="table-data" class="selective-table" data="users">
                    <thead>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Customer Name</td>
                            <td>Location</td>
                            <td>Backup Quota</td>
                            <td>Backup Size</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="sub-content">
        <div class="tile-body" style="padding: 0; padding-bottom: 4px;">
            <div class="close-btn" target="#sub-content">
                <i class="fa fa-close"></i>
            </div>
        </div>

        <div class="tile">
            <i class='fa fa-user'></i>
            <div>
                <div class="tile-body">
                    <div class="intro">Name</div>
                    <div class="title  data-holder" data="name">None</div>
                </div>
                <div class="tile-body">
                    <div class="intro">Contact</div>
                    <div class="title  data-holder" data="contact">None</div>
                </div>
            </div>
        </div>

        <div class='tile'>
            <div class="row">
                <div class="btn btn-primary data-holder-action" action="delete_user" data="">Delete</div>
                <div class="btn btn-primary data-holder-action" data="">Edit</div>
            </div>
        </div>


        <div class="tile">
            <i class='fa fa-map-marked'></i>
            <div>
                <div class="tile-body">
                    <div class="intro">Location</div>
                    <div class="title data-holder" data="location">None</div>
                </div>
                <div class="tile-body">
                    <div class="intro">Date Joined</div>
                    <div class="title  data-holder" data="date_created">None</div>
                </div>

            </div>
        </div>

        <div class="tile">
            <i class='fa fa-database'></i>
            <div>
                <div class="tile-body">
                    <div class="intro">Backup Quota</div>
                    <div class="title  data-holder" data="backup_quota">None</div>
                </div>
                <div class="tile-body">
                    <div class="intro">Total Backup Size</div>
                    <div class="title  data-holder" data="backup_size">None</div>
                </div>
                <div class="tile-body">
                    <div class="intro">Last Backup Date</div>
                    <div class="title  data-holder" data="date_updated">None</div>
                </div>
            </div>
        </div>

    </div>