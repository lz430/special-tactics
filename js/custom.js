// Child theme JS

  $(window).ready(function(){
    // $('.coming-soon .grid-course').each(function(){
    //   $(this).prepend("<div class='coverage'> <h2> Coming Soon! </h2></div>")
    // });
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


    }) ;
    