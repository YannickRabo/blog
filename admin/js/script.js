var $rows = $('tbody tr');
$('.recherche').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});

function logout(){
  if (confirm('Are you sure you want to logout?')){
    return true;
  }else{
    return false;
  }
}

function deleteart(){
    if (confirm('Are you sure you want to delete the article?')){
        return true;
    }else{
        return false;
    }
} 

function deleteuser(){
    if (confirm('Are you sure you want to delete the User?')){
        return true;
    }else{
        return false;
    }
}

function deletecomm(){
    if (confirm('Are you sure you want to delete the comment?')){
        return true;
    }else{
        return false;
    }
}

function deletecategory(){
    if (confirm('Are you sure you want to delete the category?')){
        return true;
    }else{
        return false;
    }
}

$("#showHide").click(function () {
    if ($(".password").attr("type")=="password") 
    {
        $(".password").attr("type", "text");
    }
    else
    {
        $(".password").attr("type", "password");
    }
});

$("h2 span").html($('tbody tr:visible').length);


tinymce.init({
  selector: "textarea",  // change this value according to your html
  plugins: "textcolor",
  toolbar: "forecolor backcolor"
});

const source = document.querySelector(".category");
const target = document.querySelector(".secondCat");

const displayWhenSelected = (source, value, target) => {
    const selectedIndex = source.selectedIndex;
    const isSelected = source[selectedIndex].value === value;
    target.classList[isSelected
        ? "add"
        : "remove"
    ]("show");
};
source.addEventListener("change", (evt) =>
    displayWhenSelected(source, "8", target)
);



$(document).ready(function() {

    $("#sub option").filter(function() {
        return $(this).val() == $("#title").val();
    }).attr('selected', true);

    $("#sub").live("change", function() {

        $("#title").val($(this).find("option:selected").attr("value"));
    });
});


function insertText(elemID, text)
{
    var elem = document.getElementById(elemID);
    elem.innerHTML += text;
}