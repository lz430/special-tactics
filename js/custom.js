// Child theme JS
$(window).ready(function(){
  if(js_data.is_activity_dir){
      filter = $('#activity-filter-select select').val();
      $.removeCookie('bp-activity-scope', {
          path: '/'
      });
      //change 'groups' with the cookie for the tab you want to be the default one
      // favorites , friends, etc
      $.cookie( 'bp-activity-scope', 'all');
      scope = $.cookie('bp-activity-scope');
      bp_activity_request(scope, filter);
  }
}) ;

$(document).ready(function(){
    $('body.single-sfwd-courses #btn-join').val("$39.99 - Purchase This Course");
    $('.bb-user-notifications a:not(".bb-message-link") ').each(function(){
        var linkText = $(this).text();
        $(this).before(linkText);
        $(this).remove();
    });

    // Courses - watch intro replacement text
    var textR = $('body.logged-in .course-buttons #show-video').contents();
    // console.log(textR);
    // textR[1].textContent="General course instructions";

    // var pmpHeadingText = "<h1 style='width: 100%;font-size: 45px;color: #000000;text-align: center' class='vc_custom_heading'>U.S. Government Personnel</h1> <div style='width: 52%;' class='vc_separator wpb_content_element vc_separator_align_center vc_sep_width_50 vc_sep_pos_align_center vc_separator_no_text'><span class='vc_sep_holder vc_sep_holder_l'><span style='border-color:#ffb606;' class='vc_sep_line'></span></span><span class='vc_sep_holder vc_sep_holder_r'><span style='border-color:#ffb606;' class='vc_sep_line'></span></span></div>";
    // $('#pmpro_levels_pricing_tables > .pmpro_levels_pricing_table:nth-child(2)').after(pmpHeadingText);

    // Change text for PMP checkout account info
    $('#pmpro_user_fields_a').text('create a username and password.');

    // Hide friendship accept/reject buttons when the other is clicked
    $('.generic-button > .accept').on('click', function(){
      $(this).parent().parent().find('.reject').hide();
    });

    $('.generic-button > .reject').on('click', function(){
      $(this).parent().parent().find('.accept').hide();
    });

    // Add clas to PMP pro table
    $('#pmpro_levels_pricing_tables > .pmpro_levels_pricing_table:nth-child(2)').addClass('popular');
        
}) ;
