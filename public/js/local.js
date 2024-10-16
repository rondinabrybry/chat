
$(".conv-list .convo").each(function(data){
    $(this).click(function(){
        room_id = $(this).find("#room_id").val()

        $.ajax({
            url: "../controls/inbox.cntrl.php",
            type: "POST",
            data: {room_id},
            success: function(data){
                console.log(data);
                if(data == "setRoom"){
                    window.location.href = "../views/chat.view.php";
                }
            }
        })
    })
})

$(".report-form").on("submit", (e)=>{
    e.preventDefault();

    chat_id = $(".report-form #chat_id").val();
    reason = $("#reason").val();

    $.ajax({
        url: "../controls/report.cntrl.php",
        type: "POST",
        data: { chat_id, reason },
        success: (data)=>{
            
            Swal.fire({
                position: "center",
                toast: true,
                icon: "success",
                title: data,
                showConfirmButton: false,
                timer: 1500
              });

            menu_toggle();
        }
    })
})
