<div class="row" ng-app="myApp">
    <div class="col-md-12" ng-controller="productsCtrl">
        <?php cn_form_open('mod, opt'); ?>
        <input type="hidden" name="actionUpload" ng-model="drivers.actionUpload">

        <button type="button" class="btn btn-danger fa fa-plus" ng-click="open(product);">&nbsp;File Upload</button>
        <!--        <button type="button" class="btn btn-danger fa fa-trash-o" ng-click="open(drivers);">&nbsp;File In Trash</button>-->
        <div class="table-responsive">
            <div class="panel panel-primary">
                <div class="panel-heading col-lg-12 display-list">
                    <div class="col-sm-7">
                        <input type="radio" name="checkSort" ng-click="actSort(sort)" id="sort-a"
                               ng-model="sort.sortList" value="a"/><label class="cursor-pointer pd-left5 mg-right10"
                                                                          for="sort-a">↑ ASC</label>
                        <input type="radio" name="checkSort" ng-click="actSort(sort)" id="sort-d"
                               ng-model="sort.sortList" value="d" class="bd"><label
                            class="cursor-pointer pd-left5 mg-right10" for="sort-d">↓ DESC</label>
                        <input type="checkbox" ng-click="actTrash()" ng-model="checkInTrash" id="checkInTrash"><label
                            class="cursor-pointer pd-left5" for="checkInTrash">Trash</label>
                    </div>
                    <div class="sw-search pull-right col-sm-5">
                        <div class="nav-search c-right" id="nav-search">
                            Filter: <span class="input-icon">
                            <input placeholder="Filter products list ..." class="nav-search-input"
                                   ng-model="filterProduct"
                                   ng-change="resetLimit();" autocomplete="off" type="text" style="" focus>
                        <i class="search-icon fa fa-search nav-search-icon"></i></span>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-responsive">
                    <tr>
                        <th ng-repeat="c in columns">{{c.text}}</th>
                    </tr>
                    <tr ng-repeat="c in products | filter:filterProduct | orderBy:'-id'" id="{{c.id}}">
                        <td>{{$index+1}}</td>
                        <td>{{c.nameFile}}</td>
                        <td>{{c.size}}</td>
                        <td>{{c.alias}}</td>
                        <td>{{c.createdTime}}</td>
                        <td>{{c.modifiedTime}}</td>
                        <td>
                            <button ng-hide="checkInTrash" class="btn ng-binding"
                                    ng-class="{1:'btn-success', '0':'btn-default-cus'}[c.shareDownload]"
                                    ng-click="changeProductStatus(c);">Inactive
                            </button>
                        </td>
                        <td>
                            <div class="btn-group" ng-hide="checkInTrash">
                                <button type="button" class="btn btn-default fa fa-edit" ng-click="open(c);"></button>
                                <button type="button" class="btn btn-danger fa fa-trash-o"
                                        ng-click="deleteItemDrivers(c);"></button>
                            </div>
                        </td>
                        <td>
                            <button class="ng-binding" ng-class="{'true': 'btn btn-success'}[c.isTrash]"
                                    ng-show="checkInTrash" ng-click="restoreTrash(c)">Restore
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- AngularJS custom codes -->
<script type="text/javascript" src="/admin/js/ApiUpload/drivers/app.js"></script>
<script type="text/javascript" src="/admin/js/ApiUpload/drivers/data.js"></script>
<script type="text/javascript" src="/admin/js/ApiUpload/drivers/directives.js"></script>
<script type="text/javascript" src="/admin/js/ApiUpload/drivers/productsCtrl.js"></script>
