/* 
 * Made by M4ciej
 */
$(document).ready(function () {
    function showDescription(event) {
        console.log($(this).parent());
        var id = $(this).parent().attr('id');
        $.getJSON("http://localhost/bookrental/api/books.php?id=" + id, function (data) {
            console.log(data);
            $("#" + data.id).find(".desc").text(data.description);
            $("#" + data.id).find(".desc").slideToggle();

        })
    }
    function deleteBook(event) {
        var id = $(this).parent().attr('id');
        var request = $.ajax({
            url: "http://localhost/bookrental/api/books.php",
            method: "DELETE",
            data: {id: id},
        });

        request.done(function (msg) {
            $("#messages").text(msg);
            booksRequest();
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }
    function booksRequest() {
        $.getJSON('http://localhost/bookrental/api/books.php', function (data) {
            //console.log(data);
            $("#books").empty();
            $("#books").append("<ul id='list'>");
            for (var i = 0; i < data.length; i++) {
                //console.log(data);
                var li = $("<li class='book' id='" + data[i].id + "'>");
                var title = $("<span class='title'>");
                var del = $("<button>");
                del.text("skasuj");
                var desc = $("<div class='desc'>");
                desc.hide();
                title.text(data[i].title);
                title.on("click", showDescription);
                li.append(title);
                del.on("click", deleteBook);
                li.append(del);
                li.append(desc);
                $("#list").append(li);
                //tmp.append(desc);
                //console.log(tmp);
            }

        })
    }
    ;
    booksRequest();
    $("form").find(":submit").on("click", function (event) {
        event.preventDefault();
        var tresc = new Array();
        var errormsg = "";
        $("form").find("input").each(function () {
            if ($(this).val()) {
                tresc[$(this).attr('name')] = $(this).val();
            } else {
                errormsg += "wypełnij " + $(this).attr('name') + ",";
            }
        })
        if (errormsg.length == 0) {
            var request = $.ajax({
                url: "http://localhost/bookrental/api/books.php",
                method: "POST",
                data: {title: tresc['title'], author: tresc['author'], description: tresc['description']},
            });

            request.done(function (msg) {
                $("#messages").text(msg);
                booksRequest();
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        } else {
            $("#messages").text(errormsg);
        }

    })
});

