$('#tree').on("move_node.jstree", function (e, data) {

    var source;    // перемещаемый
    var target;    // принимающий
    console.log('source: '+data.node.id);    // Id перемещаемого
    source  = data.node.id;
    console.log('target: '+data.parent);    // id принимающего
    target = (data.parent !== 'root')? data.parent :null;   // root - корень дерева

    var inst = $('#tree').jstree(true),
        node = inst.get_node(source),
        parent = inst.get_node(node.parent);

    var order = JSON.stringify(parent.children);   // передаём детей в принимающем для сохранения их положения


    $.ajax({
        url: AJAXMOVEMENTSECTIONPATH,
        data: 'source=' + source +'&target='+target+'&order='+order,
        cache: false

    });

});



$("#tree").on("select_node.jstree", function (e, data) {
    var href = data.node.a_attr.href;
    $("#btn_sec_update").prop("href", href);
    $("#btn_sec_update").removeAttr('disabled');
    $("#btn_sec_delete").removeAttr('disabled');
    console.log(data.node.id);
});

// onclick btn_sec_delete node delete
function deleteNode(){
    var selNode =$('#tree').jstree(true).get_selected();
    var selId = selNode[0];
    if (selId!=='underfind') {
        $.ajax({
            url: AJAXDELETESECTIONPATH,
            data: 'id=' + selId,
            cache: false,
            success: function () {
                $('#tree').jstree().delete_node(selNode);
            },

        });
    }
}