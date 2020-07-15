
<form>
    <input id="default_file" type="file" name="photo"/>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $('#default_file').change(function(){
        //on change event
        formdata = new FormData();
        if($(this).prop('files').length > 0)
        {
            file =$(this).prop('files')[0];
            formdata.append("photo", file);

            jQuery.ajax({
                url: 'http://trello.local/api/tasks',
                headers: {
                  'Authorization' : 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMjk2NTA3NzRmNTA2ODNkYjNkMDgxNWQyYjMxYWZlZGNiYjE5ZDE1YTg4MzI5ODk4ZWIxMmRiMjAyNDM0OTMxNjA5ZjQ5M2Y1MTAzNTY3YzYiLCJpYXQiOjE1OTQ0ODgyOTIsIm5iZiI6MTU5NDQ4ODI5MiwiZXhwIjoxNjI2MDI0MjkyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.jg5ibsxihl31D5VxrCXttixxJ_T11oa2j3A80xVWTjkz6hSdoQk2OAyRNjeJSMHHqj4VsE0ioR7JYUDhphAV8aXsy7M4KCN8b1_h-v2e8NmQgtO_XMEnU_b2zkuBgq6pY54PwxpC3vs_4QCl8vuXsTsD1lIOXJehKzhHNb0K_AXDcfeRgRCb0agquXs0X7gphEbx35GZGxeVRFf9xFRlHY5O4djxd-2oxErOTR4mKAh4c8h-3BxN5E5trS5e4elkZYFhyeIQEaGvU2VBKpu8gQSP_tsfvEs0SY-p-Onm6X8ar4wsSKu5KATrsQWGgbl0zrOm3JXC6ndFiS375GwqiOAAw9COXiiG4TEQlqRezmI7sDfWBh_JNib2Ep8lm19Is4RQd9gk7Ze8_yK2dtDrDsIz2YbmCkIkQX7E8-I3GzgrgLTlJ91g4WYGMxDyb-HS_uTSjAAgCVcjcne7hhGr-kIUfjhmghml74EiFcK2UYqd71GBdkIJnGR-D6A-SudTt1nHFL6MsjrTT2UggVg1q5dnE3b3ebHJ5k7eAq_7DbVnA1s8B6HPM9NCFlpOBGrykxd6DUAe9J0_iWtsTkxJq4YtHXOMLRujX3kAkLzatsmlQ8lkL-SbWYl8R0BwttjiwKR_Bj4dNy3OF3NY7oQxzCBsqImMvN5v7_gqXBJgpn4'
                },
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (result) {
                    // if all is well
                    // play the audio file
                }
            });
        }
    });


</script>
