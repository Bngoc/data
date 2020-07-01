window.http_arr = new Array();

app.factory("Data", ['$http', '$location',
    function ($http, $q, $location) {

        // var serviceBase = 'api/v1/';
        var serviceBase = '?actAng=1';

        var obj = {};

        obj.getData = function (rUrl, object, addObject) {
            Object.assign(object, addObject);
            return $http({
                method: 'GET',
                url: rUrl,
                params: object,
                headers: {
                    'Content-Type': 'application/text'
                }
            }).success(function (data, status, headers, config) {
                return data;
            });
        };

        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        obj.deleteItemApi = function (cUrl, object) {
            return $http({
                method: 'DELETE',
                url: cUrl,
                data: object,
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded;charset=utf-8'
                }
            }).then(function (done) {
                return done;
            }, function (response) {
                //faile
            });
        }

        obj.putFrom = function (cUrl, object) {
            return $http({
                method: 'POST',
                url: cUrl,
                data: object,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (results) {
                return results.data;
            });
        };

        obj.uploadFile = function (url, object, files) {
            var formdata = new FormData();
            Object.keys(object).forEach(function (key) {
                formdata.append(key, object[key]);
            });

            // for (var index in files) {
            //     formdata.append('myfile[' + index+']', files[index]);
            // }

            formdata.append('myfile', files);

            var status = {progress: 0};
            // var defer = $q.defer();

            return $http({
                method: 'POST',
                withCredentials: false,
                url: url,
                // url: url + '?' + serializeData(object),
                headers: {
                    // 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    // 'Content-Type': 'multipart/form-data; charset=utf-8'
                    'Content-Type': undefined
                },
                // transformRequest: function (files) {
                //     // formData.append("model", angular.toJson(object));
                //     for (var i = 0; i < files.length; i++) {
                //         formData.append("myfile", files);
                // }
                // return formData;
                // },
                transformRequest: angular.identity,
                // transformRequest: angular.formDataObject,
                data: formdata,
                // data: serializeData(object),
                file: formdata,

                // progressall: function (e, data) {
                //     status.progress = parseInt(data.loaded / data.total * 100, 10);
                //     console.log(data);
                // },
                timeout: 30000,
                cache: false,
                uploadEventHandlers: {
                    progress: function (e) {
                        // defer.notify(e.loaded * 100 / e.total);
                        // console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                    }
                }
                // }).progress(function (evt) {
                //     console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                // $scope.progressBar = parseInt(100.0 * evt.loaded / evt.total);
            }).success(function (data, status, headers, config) {
                // defer.resolve(responce);
                return data;
            }).error(function (data, status, headers, config) {
                return data
                // defer.resolve(responce);
            });

            // var fd = new FormData();
            // angular.forEach(files, function (file) {
            //     console.log(file);
            //     fd.append('myfile', file);
            // });
            // fd.append('data', JSON.stringify(object));
            //
            // return $http({
            //     method: 'POST',
            //     url: url,
            //     data: serializeData(object),
            //     transformRequest: angular.identity,
            //     headers: {
            //         'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            //         // 'Content-Type': 'multipart/form-data; charset=utf-8'
            //         // 'Content-Type': undefined
            //     }
            // // }).progress(function (evt) {
            // //     return parseInt(100.0 * evt.loaded / evt.total, 10);
            // }).success(function (data, status, headers, config) {
            //    return data;
            // }).error(function (data, status, headers, config) {
            //
            // });
            // return defer;
        };

        obj.apiUploadFileByMe = function (url, drivers, files, done, progress, speedUpload, vIndex) {

            var xhr = new XMLHttpRequest();
            http_arr.push(xhr);
            var formdata = new FormData();

            Object.keys(drivers).forEach(function (key) {
                formdata.append(key, drivers[key]);
            });

            formdata.append('myfile', files);


            // angular.forEach(files, function(v, k){
            //     formdata.append("myfile[]", v);
            // });


            // xhr.upload.addEventListener("progress", uploadProgress, false);
            // xhr.addEventListener("load", uploadComplete, false);
            // xhr.addEventListener("error", uploadFailed, false);
            // xhr.addEventListener("abort", uploadCanceled, false);
            // xhr.open("POST", url);
            // scope.progressVisible = true;
            // xhr.send(formdata);

            var oldLoaded = 0;
            var oldTime = 0;

            if (typeof speedUpload == 'function') {
                xhr.upload.addEventListener('progress', function (event) {
                    if (oldTime == 0) { //Set thời gian trước đó nếu như bằng không.
                        oldTime = event.timeStamp;
                    }
                    speedUpload.call(xhr, speedRate(oldTime, event.timeStamp, oldLoaded, event.loaded), vIndex);
                    oldTime = event.timeStamp; //Set thời gian sau khi thực hiện xử lý
                    oldLoaded = event.loaded; //Set dữ liệu đã nhận được
                });
            }

            if (typeof progress == 'function') {
                xhr.upload.addEventListener('progress', function (e) {
                    progress.call(xhr, parseInt((e.loaded * 100) / e.total), vIndex);
                });
            }
            if (typeof done == 'function') {
                xhr.onreadystatechange = function () {

                    if (xhr.readyState == 4 && xhr.status == 200) {
                        //     $rootScope.$apply(function() {
                        return done.call(xhr, xhr.responseText, vIndex);
                        //     });
                        //
                    }

                    // xhr.removeEventListener('progress');
                }
            }

            xhr.open('POST', url, true);
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhr.send(formdata);
        };

        obj.canelUpload = function (rUrl, object) {
            for (i = 0; i < http_arr.length; i++) {
                http_arr[i].abort();
            }

            return $http({
                method: 'GET',
                url: rUrl,
                params: object,
                headers: {
                    'Content-Type': 'application/text'
                }
            }).success(function (data, status, headers, config) {
                return data;
            }).error(function (data, status, headers, config) {
                return data;
            });
        };

        function uploadProgress(evt) {
            scope.$apply(function () {
                if (evt.lengthComputable) {
                    scope.progress = Math.round(evt.loaded * 100 / evt.total)
                } else {
                    scope.progress = 'unable to compute'
                }
            })
        }

        function uploadComplete(evt) {
            /* This event is raised when the server send back a response */
            alert(evt.target.responseText)
        }

        function uploadFailed(evt) {
            alert("There was an error attempting to upload the file.")
        }

        function uploadCanceled(evt) {
            scope.$apply(function () {
                scope.progressVisible = false
            })
            alert("The upload has been canceled by the user or the browser dropped the connection.")
        }

        function speedRate(oldTime, newTime, oldLoaded, newLoaded) {
            var timeProcess = newTime - oldTime; //Độ trễ giữa 2 lần gọi sự kiện
            if (timeProcess != 0) {
                var currentLoadedPerMilisecond = (newLoaded - oldLoaded) / timeProcess; // Số byte chuyển được 1 Mili giây
                return parseInt((currentLoadedPerMilisecond * 1000) / 1024); //Trả về giá trị tốc độ KB/s
            } else {
                return parseInt(newLoaded / 1024); //Trả về giá trị tốc độ KB/s
            }
        }

        function serializeData(data) {
            // If this is not an object, defer to native stringification.
            if (!angular.isObject(data)) {
                return ((data == null) ? "" : data.toString());
            }
            var buffer = [];
            // Serialize each key in the object.
            for (var name in data) {
                if (!data.hasOwnProperty(name)) {
                    continue;
                }
                var value = data[name];
                buffer.push(encodeURIComponent(name) + "=" + encodeURIComponent((value == null) ? "" : value));
            }
            // Serialize the buffer and clean it up for transportation.
            var source = buffer
                .join("&")
                .replace(/%20/g, "+")
            ;
            return (source);
        }

        return obj;
    }]);


app.service('fileUpload', ['$http', function ($http) {
    // this.uploadFileToUrl = function (file, uploadUrl, nameQueryString) {
    //     var fd = new FormData();
    //     fd.append('myfile', file);
    //
    //     Object.keys(nameQueryString).forEach(function(key) {
    //         fd.append(key, nameQueryString[key]);
    //     });
    //
    //     // jQuery.each(nameQueryString, function(key, value) {
    //     //     fd.append(key, value);
    //     // })
    //
    //
    //     $http.post(uploadUrl, fd, {
    //         transformRequest: angular.identity,
    //         headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;', 'Process-Data': false}
    //     })
    //         .success(function (results) {
    //             console.log("Success");
    //             return results;
    //         })
    //         .error(function () {
    //             console.log("error");
    //         });
    // }
}]);

app.filter("trust", ['$sce', function ($sce) {
    return function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };
}]);


app.factory('transData', function ($rootScope) {
    var mem = {};

    return {
        store: function (key, value) {
            mem[key] = value;
        },
        get: function (key) {
            return mem[key];
        }
    };
});
