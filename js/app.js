/* 
 * Made by M4ciej
 */
$(document).ready(function () {
    function printBooks(books) {
        $.each(books, function (index, value) {
            var book=$("div.book");
            book.text($(this)['title']);
            $("div.books").append(book);
        });
    }
    $.ajax({

        url: "http://localhost/bookrental/api/books.php",

        data: {},

        type: "GET",

        dataType: "json",

        success: function (json) {
            
    },

        error: function (xhr, status, errorThrown) {},

        complete: function (xhr, status) {}

    });
    //$.ajax();
    $.getJSON('http://localhost/bookrental/api/books.php',function (data){
        //console.log(data);
        $("#books").append("<ul id='list'>");
        for(var i=0;i<data.length;i++){
            //console.log(data);
            var li=$("<li class='book' id='"+data[i].id+"'>");
            li.text(data[i].title);
            $("#list").append(li);
        }
        console.log($("li.book"));
        $("li.book").on("click",function(){
            //alert($(this).attr('id'));
            var id=$(this).attr('id');
            $.getJSON("http://localhost/bookrental/api/books.php?id="+$(this).attr('id'),function(data){
                console.log(data);
                $("#"+data.id).append("<div>");
                $("#"+data.id).find("div").text(data.author);
            })
        })
        
    })
});

