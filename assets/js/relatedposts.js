/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


jQuery( function ( $ ) {
  
    $(document).ready(function(){
      
      $('.ds8-related-posts').slick({
        dots: true,
        centerPadding: '60px',
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: true,
              dots: true,
              centerPadding: '40px',
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: true,
              dots: false,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
      
    });
  
});
