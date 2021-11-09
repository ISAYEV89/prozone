import $ from "jquery";
import './lightgallery/jquery-mousewheel'
import './lightgallery/lightgallery@1.6.12'
import './lightgallery/lg-fullscreen'
import './lightgallery/lg-thumbnail'


$(document).ready(function() {
    $("#lightgallery").lightGallery();
});