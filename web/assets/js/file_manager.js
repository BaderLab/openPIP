/**
 * 
 */

 function copyFunction(id) {
    /* Get the text field */
    console.log(id);
    var copyText = document.getElementById(id);
    copyText.style.display = "block";
  
    /* Select the text field */
    copyText.select();
    console.log(copyText.value);
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
  
    /* Copy the text inside the text field */
    document.execCommand("copy");
    copyText.style.display = "none";
  
    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
  }