var DataTable = "";
function GetDataTable(selector, url, columns, filter, ajaxdata = (d)=>{}) {
    DataTable = $(selector).DataTable({
        responsive: true,
        dom: '<"top"<"left-col"B><"right-col"f>>r<"table table-striped"t>ip',
        order: [
            [0, 'desc']
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        buttons: ['pageLength'],
        ajax: {
            url: url,
            dataSrc: '',
            data: ajaxdata()
        },
        columns: columns
    });
if(filter){
    $('.left-col').append(`
                <div class="row ml-2">
                    <div class="mx-1"><input onchange = "DataTable.ajax.reload();" type="date" id="date_from" name="date_from" class="form-control">
                    </div>
                    <div class="mx-1"><input onchange = "DataTable.ajax.reload();" type="date" id="date_to" name="date_to" class="form-control">
                    </div>
                    <button class="btn btn-danger" onclick="$('#date_from').val(''); $('#date_to').val('');DataTable.ajax.reload();">x</button>
                </div>
        `)
}


}


var dID = (id) => document.getElementById(id);

        function filledit(d) {
            let k = Object.keys(d)
            for (let i = 0; i < k.length; i++) dID(k[i]) ? dID(k[i]).value = d[k[i]] : ""
        }

        function alertmsg(msg, type) {
            $("#error").removeClass().html('').show();
            $("#error").addClass(`alert alert-${type} text-center`).html(msg);
            $("#error").fadeOut(3000);
        }

        function confirmdlt(func) {
            swal({
                    title: "Are You Sure?",
                    text: "Once Deleted You will not be able to go back",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,

                })
                .then((willDelete) => {
                    if (willDelete) {
                        func()
                    }
                });
        }

        function imagepreview(input, preview, size = 50){
            if (!$(input).length || !$(preview).length) {
                throw new Error('Input or preview element not found.');
              }
            $(preview).css({
                'width': '100%','height': '300px','background': 'rgb(151, 151, 151) center / contain no-repeat'
            });
            $(input).on('change', (e) => {
                $(preview).css({
                    'background-image': ``
                });
                const reader = new FileReader();
                const file = e.target.files[0];
                if (!file.type.match('image.*')) {
                    swal("Warning", "Please select an image file.", "warning");
                    return $(input).val('');
                }
                if (file.size > size * 1024 * 1024) { // Check if file size is greater than 5MB
                    swal("Warning", `The image file size exceeds the limit of ${size} mb.`, "warning");
                    return $(input).val('');
                }
                reader.onload = function(e) {
                    $(preview).css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            });
        }

        function dataURItoBlob(dataURI) {
            console.log(dataURI);
            var byteString = atob(dataURI.split(',')[1]);
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
              ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
          }




          var cropper;
          var croppedimage;
          
          function openCropperModal(id) {
            console.log('openning Model');
            var file = document.getElementById(id).files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
              var img = document.createElement('img');
              img.src = reader.result;
              img.onload = function () {
                console.log("login");
                var imageContainer = document.getElementById('imageContainer');
                imageContainer.innerHTML = '';
                imageContainer.appendChild(img);
                var cropperOptions = {
                  aspectRatio: 1,
                  viewMode: 1,
                  crop: function (event) {
                    // Access cropped data: event.detail.x, event.detail.y, event.detail.width, event.detail.height
                  }
                };
                cropper = new Cropper(img, cropperOptions);
                $('#overlay').hide()
                $('#cropperModal').modal('show');
              };
            };

            if (file) {
              reader.readAsDataURL(file);
            }
          }

          function cropImage() {
            if (cropper) {
              var canvas = cropper.getCroppedCanvas();
              croppedimage = canvas.toDataURL('image/jpeg');
              $('#cropperModal').modal('hide');
            } else {
              swal("Info!", 'Please select an image and start the cropper.', "warning")
            }
          }
