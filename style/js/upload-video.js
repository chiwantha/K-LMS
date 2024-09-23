async function getUploadDetails(file) {
    const response = await fetch('ajax/upload-video.php', {
        method: 'POST',
        body: new URLSearchParams({ filename: file.name })
    });
    const data = await response.json();
    return data;
}

document.getElementById('upload').addEventListener('click', async () => {
    const file = document.getElementById('video').files[0];
    if (!file) {
        $('#errorToast').toast("show");
        $('#errorMessage').html('Please select a file first !');
        //alert('Please select a file first');
        return;
    }

    const { presignedSignature, expirationTime, videoGuid, libraryId } = await getUploadDetails(file);

    const upload = new tus.Upload(file, {
        endpoint: "https://video.bunnycdn.com/tusupload",
        retryDelays: [0, 3000, 5000, 10000, 20000, 60000, 60000],
        chunkSize: 10 * 1024 * 1024, // 10MB chunk size
        metadata: {
            filename: file.name,
            filetype: file.type
        },
        headers: {
            "AuthorizationSignature": presignedSignature,
            "AuthorizationExpire": expirationTime,
            "VideoId": videoGuid,
            "LibraryId": libraryId
        },
        onError: function (error) {
            console.error("Failed because: " + error);
        },
        onProgress: function (bytesUploaded, bytesTotal) {
            const percentage = (bytesUploaded / bytesTotal) * 100;
            console.log(bytesUploaded, bytesTotal, percentage + "%");
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentage + "%";
            progressBar.innerText = "Progress " + Math.floor(percentage) + "%";
        },
        onSuccess: function () {
            //console.log("Upload successful. Download URL: %s", upload.url);
            console.log("Video ID: " + videoGuid); // Log the video ID after successful upload
            document.getElementById('video-id').value = videoGuid;
            //document.getElementById('submit').disabled = false;
            
        }
    });

    // Start the upload
    upload.start();
});

document.getElementById('upload-edit').addEventListener('click', async () => {
    const file = document.getElementById('video-edit').files[0];
    if (!file) {
        $('#errorToast').toast("show");
        $('#errorMessage').html('Please select a file first !');
        //alert('Please select a file first');
        return;
    }

    const { presignedSignature, expirationTime, videoGuid, libraryId } = await getUploadDetails(file);

    const upload = new tus.Upload(file, {
        endpoint: "https://video.bunnycdn.com/tusupload",
        retryDelays: [0, 3000, 5000, 10000, 20000, 60000, 60000],
        chunkSize: 10 * 1024 * 1024, // 10MB chunk size
        metadata: {
            filename: file.name,
            filetype: file.type
        },
        headers: {
            "AuthorizationSignature": presignedSignature,
            "AuthorizationExpire": expirationTime,
            "VideoId": videoGuid,
            "LibraryId": libraryId
        },
        onError: function (error) {
            console.error("Failed because: " + error);
        },
        onProgress: function (bytesUploaded, bytesTotal) {
            const percentage = (bytesUploaded / bytesTotal) * 100;
            console.log(bytesUploaded, bytesTotal, percentage + "%");
            const progressBar = document.getElementById('progressBar-edit');
            progressBar.style.width = percentage + "%";
            progressBar.innerText = "Progress " + Math.floor(percentage) + "%";
        },
        onSuccess: function () {
            //console.log("Upload successful. Download URL: %s", upload.url);
            console.log("Video ID: " + videoGuid); // Log the video ID after successful upload
            document.getElementById('video-id-edit').value = videoGuid;
            //document.getElementById('submit').disabled = false;
            
        }
    });

    // Start the upload
    upload.start();
});