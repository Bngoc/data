<!--<button type="button" class="close" ng-click="cancel();">-->
<!--    <i class="fa fa-times-circle-o" style="margin:10px;color:blue;"></i>-->
<!--</button>-->
<div class="panel panel-default" id="myModal" data-backdrop="static" data-keyboard="false" data-toggle="modal">
    <div class="panel-body">
        <form role="form" method="post" enctype="multipart/form-data" name="fileinfo"
              ng-submit="uploadFileByMe(drivers, $event)">
<!--              ng-submit="apiUploadFileDrivers(drivers, $event)">-->
            <!--<form role="form" method="post" enctype="multipart/form-data" name="fileinfo" onsubmit="return doUpload();">-->
            <div class="form-group">
                <label for="myfile">File Upload</label>
                <!--                <input type="file" class="form-control" onchange="angular.element(this).scope().filesChanged(this.files)" name="myfile" file-model="drivers.myfile" id="myfile" multiple />-->
                <input type="file" class="form-control"
                       onchange="angular.element(this).scope().seletedFile(this)"
                       name="myfile" file-model="myfile" id="myfile" multiple/>
                <div class="modal-body" style="padding: 0;">
                    <div class="progress-group mg-top5" ng-repeat="file in fileList.slice(0)">
                        <div class="progress">
                            <div class="progress-bar" id="fileInfo_{{$index}}">
                                <div class="pull-left text-color progress-name">[{{$index +
                                    1}}]-{{file.webkitRelativePath || file.name}}
                                    (<span ng-switch="file.size > 1024*1024">
                                    <span ng-switch-when="true">{{file.size / 1024 / 1024 | number:2}} MB</span>
                                    <span ng-switch-default>{{file.size / 1024 | number:2}} kB</span>
                                </span>)
                                </div>
                            </div>
                            <span id="upSpeed_{{$index}}" class="text-color progress-text"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="msgError">
                <div class="display-none" ng-bind-html="msgError | trust"></div>
            </div>

            <div class="modal-footer">
                <input type="submit" ng-disabled="isDisabled" class="btn btn-default" value="Upload"/>
                <input type="button" class="btn btn-default" value="Cancle" ng-click="cancel();"/>
<!--                <input type="button" class="btn btn-default" value="Cancle" onclick="cancleUpload();"/>-->
            </div>
        </form>
    </div>
</div>


<!---->
<!--<div class="modal-header">-->
<!--    <h3 class="modal-title">Edit product [ID: {{product.id}}]</h3>-->
<!--</div>-->
<!--<div class="modal-body">-->
<!--    <form name="product_form" class="form-horizontal" role="form" novalidate>-->
<!--        <form-element label="NAME" mod="product">-->
<!--            <input type="text" class="form-control" name="name" placeholder="NAME" ng-model="product.name"-->
<!--                   ng-disabled="product.id" focus/>-->
<!--        </form-element>-->
<!--        <form-element label="DESCRIPTION" mod="product">-->
<!--            <textarea class="form-control" name="description" placeholder="DESCRIPTION" ng-model="product.description">{{product.description}}</textarea>-->
<!--        </form-element>-->
<!--        <form-element label="PRICE" mod="product">-->
<!--            <input type="text" name="price" class="form-control" placeholder="PRICE" ng-model="product.price"-->
<!--                   only-numbers/>-->
<!--            <small class="errorMessage" ng-show="product_form.price.$dirty && product_form.price.$invalid"> Enter the-->
<!--                price.-->
<!--            </small>-->
<!--        </form-element>-->
<!---->
<!--        <form-element label="STOCK" mod="product">-->
<!--            <input type="text" name="stock" class="form-control" placeholder="STOCK" ng-model="product.stock"-->
<!--                   only-numbers/>-->
<!--            <small class="errorMessage" ng-show="product_form.stock.$dirty && product_form.stock.$invalid"> Enter the-->
<!--                available stock.-->
<!--            </small>-->
<!--        </form-element>-->
<!---->
<!--        <form-element label="PACKING" mod="product">-->
<!--            <input type="text" name="packing" class="form-control" placeholder="PACKING" ng-model="product.packing"/>-->
<!--            <small class="errorMessage" ng-show="product_form.packing.$dirty && product_form.packing.$invalid"> Enter-->
<!--                the Packing.-->
<!--            </small>-->
<!--        </form-element>-->
<!---->
<!--        <div class="space"></div>-->
<!--        <div class="space-4"></div>-->
<!--        <div class="modal-footer">-->
<!--            <form-element label="">-->
<!--                <div class="text-right">-->
<!--                    <a class="btn btn-sm" ng-click="cancel()"><i class="ace-icon fa fa-reply"></i>Cancel</a>-->
<!--                    <button ng-click="saveProduct(product);"-->
<!--                            ng-disabled="product_form.$invalid || enableUpdate"-->
<!--                            class="btn btn-sm btn-primary"-->
<!--                            type="submit">-->
<!--                        <i class="ace-icon fa fa-check"></i>{{buttonText}}-->
<!--                    </button>-->
<!--                </div>-->
<!--            </form-element>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->

<script type="text/javascript">
//    $('#myModal').modal({backdrop: 'static', keyboard: false});
    //document.getElementById("progress-group").classList.add('display-none');
//    $('#myfile').css({ padding: "20px" });
</script>