/**
 * Created by kaushalshukla on 6/15/17.
 */


function exampleReview(example,status) {
    var exampleId = example.id;
    $.ajax({
        data:{ exampleId:exampleId, status:status , _method: "PATCH", '_token':'{!! csrf_token() !!}'},
        url: '/examples/'+exampleId+'/review',
        type: 'PATCH',
        dataType: 'json',
        success:function(resp)
        {
            //reload your page after review example
            window.location.reload();
        }
    });
}

function exampleSetAnswer(example,status) {
    var exampleId = example.id;
    $.ajax({
        data:{ exampleId:exampleId, status:status , _method: "PATCH", '_token':'{!! csrf_token() !!}'},
        url: '/examples/'+exampleId+'/set-answer',
        type: 'PATCH',
        dataType: 'json',
        success:function(resp)
        {
            //reload your page after review example
            window.location.reload();
        }
    });
}

function exampleGiveAnswer(example,status) {
    var exampleId = example.id;

    $.ajax({
        data:{ exampleId:exampleId, status:status , _method: "PATCH", '_token':'{!! csrf_token() !!}'},
        url: '/examples/'+exampleId+'/give-answer',
        type: 'PATCH',
        dataType: 'json',
        success:function(respt)
        {
            if(respt.resp=='yes'){
                $(example).parent().parent().parent().addClass("list-group-item-success");
                $(':radio').attr('disabled','disabled');
            }else {
                $(example).parent().parent().parent().addClass("list-group-item-danger");
                $(':radio').attr('disabled','disabled');
            }
            //reload your page after review example
        }
    });
}

$('.quiz-option-list').hover(function () {
    $(this).addClass('hover');
}, function () {
    $(this).removeClass('hover');
});

$(".hideMessage").delay(3000).fadeOut();