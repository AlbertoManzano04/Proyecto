// homepage
async function run () {
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      var modal_btn_svg_icon = ` <button class="btn btn-success" onclick="window.open('https://www.vwthemes.com/products/car-wordpress-theme','_blank')">BUY NOW</button>`;
      if (!jQuery('.btn-success').length) {
        jQuery('.edit-site-header-edit-mode__start , .edit-post-header-toolbar__left').append(modal_btn_svg_icon);
      }
    })
  })

  const targetElements = document.querySelectorAll('.edit-site-layout, .edit-post-layout')

  targetElements.forEach((i) => {
    observer.observe(i, {
      attributes: true,
      characterData: true,
      childList: true,
      subtree: true,
      attributeOldValue: true,
      characterDataOldValue: true
    })
  })
}

window.addEventListener('load', function load(e){
  window.removeEventListener('load', load, false);
  this.setTimeout(() => {
    run()
  }, 1000)
}, false);