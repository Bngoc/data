window.checkUpload = false;


app.controller('productsCtrl', function ($scope, $modal, $filter, Data, fileUpload, transData) {

    $scope.product = {};
    $scope.sort = {sortList: 'd'};
    addObject = {actAng:1};

    $scope.drivers = {
        // actionUpload: 1,
        mod: document.getElementsByName("mod")[0].value,
        opt: document.getElementsByName("opt")[0].value,
        __signature_key: document.getElementsByName("__signature_key")[0].value,
        __signature_dsi: document.getElementsByName("__signature_dsi")[0].value,
        sort: $scope.sort.sortList || 'd',
        trash: document.getElementById('checkInTrash').checked || false
        // myfile: document.getElementById('myfile').files
    };

    $scope.actSort = function () {
        $scope.drivers['sort'] = $('input[name="checkSort"]:checked').val();

        Data.getData('admin.php', $scope.drivers, addObject).then(function (results) {
            try {
                $scope.products = results.data.body.data;
            } catch (e){

            }
        });

    };

    $scope.actTrash = function () {
        $scope.drivers['trash'] = document.getElementById('checkInTrash').checked || false;

        Data.getData('admin.php', $scope.drivers, addObject).then(function (results) {
            try {
                $scope.products = results.data.body.data;
            } catch (e){

            }
        });
    };


    Data.getData('admin.php', $scope.drivers, addObject).then(function (results) {
        try {
            console.log(results);
            $scope.products = results.data.body.data;
        } catch (e){

        }
    });

    $scope.changeProductStatus = function (product) {

        product.status = (product.status == "Active" ? "Inactive" : "Active");
        Data.put("products/" + product.id, {status: product.status});
    };

    $scope.deleteProduct = function (product) {
        if (confirm("Are you sure to remove the product")) {
            Data.delete("products/" + product.id).then(function (result) {
                $scope.products = _.without($scope.products, _.findWhere($scope.products, {id: product.id}));
            });
        }
    };

    $scope.open = function (p, size) {
        var modalInstance = $modal.open({
            templateUrl: pathcDataAdmin + '/com_board/addUpload.php',
            controller: 'productEditCtrl',
            size: size,
            scope: $scope,
            resolve: {
                item: function () {
                    return p;
                },
                ap: function () {
                    return $scope.newTagsData;
                }
            },
            backdrop: 'static', // disable click modal outsite
            keyboard :false     // ESC
        });

        modalInstance.result.then(function (selectedObject) {
            // console.log(selectedObject);

            $scope.products = selectedObject.data.body.data;

            // if (selectedObject.save == "insert") {
            //     $scope.products.push(selectedObject);
            //     $scope.products = $filter(' ')($scope.products, 'id', 'reverse');
            // } else if (selectedObject.save == "update") {
            //     p.description = selectedObject.description;
            //     p.price = selectedObject.price;
            //     p.stock = selectedObject.stock;
            //     p.packing = selectedObject.packing;
            // }
        });
    };

    $scope.restoreTrash = function () {
        console.log('1111');
    }

    transData.store('drivers', $scope.drivers);
    transData.store('columns', $scope.columns);

    $scope.columns = [
        {text: "ID", predicate: "id", sortable: true, dataType: "number"},
        {text: "Name", predicate: "name", sortable: true},
        {text: "Size", predicate: "price", sortable: true},
        {text: "Alias", predicate: "stock", sortable: true},
        {text: "Create File", predicate: "packing", reverse: true, sortable: true, dataType: "number"},
        {text: "Modified File", predicate: "description", sortable: true},
        {text: "Status", predicate: "status", sortable: true},
        {text: "Action", predicate: "", sortable: false},
        {text: "Trash", predicate: "", sortable: false}
    ];

    ////change files
    // $scope.seletedFile = function (element) {
    //     var files = element.files;
    //     $scope.fileList = [];
    //     for (var i = 0; i < files.length; i++) {
    //         $scope.fileList.push(files[i]);
    //         $scope.$apply();
    //     }
    // }
});

app.controller('productEditCtrl', function ($scope, $modalInstance, item, Data, transData) {

    $scope.drivers = transData.get('drivers');
    $scope.columns = transData.get('columns');

    $scope.fileList = [];

    $scope.seletedFile = function (element) {
        $scope.isDisabled = false;
        var files = element.files;
        $scope.fileList = [];
        for (var i = 0; i < files.length; i++) {
            $scope.fileList.push(files[i]);
            $scope.$apply();
        }
    }

    $scope.filesChanged = function (elm) {
        $scope.drivers.myfiles = elm.myfiles;
        $scope.$apply();
    }

     $scope.uploadFileByMe = function (drivers, vet) {
         // var ProgressBar = document.createElement('div');
         // ProgressBar.className = 'progress-bar';
         // var ProgressText = document.createElement('span');
         // ProgressText.className = 'progress-text';

         drivers['actionUpload'] = 1;

         if ($scope.fileList.length) {
             checkUpload = true;
             $scope.isDisabled = true;
             for (j = 0; j < $scope.fileList.length; j++) {
                 Data.apiUploadFileByMe('admin.php', drivers, $scope.fileList[j],
                     function (done, vIndex) {
                         // $scope.products = done.body.data;
                         try { //Bẫy lỗi JSON
                             var server = JSON.parse(done);

                             $('.msgError').children().removeClass('display-none');
                             // $scope.msgError = flashMsg(server.message, 's');
                             // $('.msgError').append().html(flashMsg(server.message, 's'));
                             $('#fileInfo_' + vIndex).removeClass('progress-bar-u').addClass('progress-bar-s');
                             $('#upSpeed_' + vIndex).html(server.statusUpload);

                         } catch (e) {
                             console.log(e);
                             $('.msgError').append().html(flashMsg(server.message, 's'));
                             // ProgressBar.className += ' progress-bar-danger'; //Thêm class Danger
                             // ProgressBar.innerHTML = 'Có lỗi xảy ra'; //Thông báo
                         }
                     }, function (progress, vIndex) {
                         // console.log('#fileInfo_' + j);
                         // console.log(progress);
                         if (progress >= 100) {

                             // $('#fileInfo_' + vIndex).removeClass('progress-bar-u').addClass('progress-bar-s');
                             $('#fileInfo_' + vIndex).css('width', progress + '%');
                             // $('div.progress-bar').fadeOut(2000, function () {
                             //     $('#image-holder').empty();
                             // });
                             // ProgressBar.style.background = '-webkit-gradient(linear, left top, left bottom, from(#6666cc), to(#4b9500)) !important';
                         } else {
                             // $('div.progress-bar').show();
                             // $(".progress-bar .current-process").css('width', progress + '%');
                             // $('#fileInfo_'+ j + 1).addClass('progress-bar-s');
                             // ProgressBar.style.background = 'url("/images/progressbar.gif")';
                             $('#fileInfo_' + vIndex).css('width', progress + '%');
                             $('#fileInfo_' + vIndex).addClass('progress-bar-u');
                         }
                     }, function (speed, vIndex) {
                         $('#upSpeed_' + vIndex).html('Upload Speed: ' + speed + 'KB/s');
                         console.log(speed);
                         // ProgressText.innerHTML = 'Upload Speed: ' + speed + 'KB/s';
                     }
                     , j, false);
             }
         } else {
             // if (result.data.status) {
             $('.msgError').children().removeClass('display-none');
             // }
             $scope.msgError = flashMsg('No file', 'e');
         }
    };


    $scope.apiUploadFileDrivers = function (drivers) {

        if ($scope.fileList.length) {
            for (i = 0; i < $scope.fileList.length; i++) {
                Data.uploadFile('admin.php', drivers, $scope.fileList[i]).then(function (result) {
                // Data.uploadFile('admin.php', drivers, $scope.fileList).then(function (result) {

                    try {
                        // if (result.data.status) {
                        $('.msgError').children().removeClass('display-none');
                        // }
                        $scope.msgError = flashMsg(result.data.message, 's');
                        // }

                        $scope.products = result.data.body.data;

                    } catch (ex) {
                    }

                    // $modalInstance.close(result);
                }, function (progress) {
                    console.log('uploading: ' + Math.floor(progress) + '%');
                });
            }
        } else {
            // if (result.data.status) {
            $('.msgError').children().removeClass('display-none');
            // }
            $scope.msgError = flashMsg('No file', 'e');
        }
        // $modalInstance.dismiss('cancel');

    };

    $scope.cancel = function () {
        if(checkUpload) {
            $scope.drivers['actAng'] = 1;
            delete $scope.drivers.actionUpload;
            checkUpload = false;
            Data.canelUpload('admin.php', $scope.drivers).then(function (results) {
                $modalInstance.close(results);
            });
        } else {
            $modalInstance.dismiss('Close')
        }
    };

    $scope.product = angular.copy(item);

    $scope.title = (item.id > 0) ? 'Edit Product' : 'Add Product';
    $scope.buttonText = (item.id > 0) ? 'Update Product' : 'Add New Product';

    var original = item;
    $scope.isClean = function () {
        return angular.equals(original, $scope.product);
    }

    $scope.saveProduct = function (product) {
        product.uid = $scope.uid;
        if (product.id > 0) {
            Data.put('products/' + product.id, product).then(function (result) {
                if (result.status != 'error') {
                    var x = angular.copy(product);
                    x.save = 'update';
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        } else {
            product.status = 'Active';
            Data.post('products', product).then(function (result) {
                if (result.status != 'error') {
                    var x = angular.copy(product);
                    x.save = 'insert';
                    x.id = result.data;
                    $modalInstance.close(x);
                } else {
                    console.log(result);
                }
            });
        }
    };
});
