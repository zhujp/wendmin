//定义基础模块
layui.define(['element','form','layer','laydate','layedit','upload'],function(exports){
    var layer = layui.layer,
        element = layui.element(),
        layedit = layui.layedit,
        laydate = layui.laydate,
        form = layui.form();

    var w_editor = layedit.build('w_editor');

    //ajax 删除记录
    $('.ajax-del').on('click',function(){
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        $.post(url,{id:id},function(result){
            if (result.code == 1) {
            layer.msg(result.msg,{icon: 6});
            setInterval(function(){
              window.location.href=result.url;
            },result.wait*1000);
            return false;
          }
          layer.msg(result.msg,{icon: 5});
        })
        return false;
    });

    //图片上传
    layui.upload({
        url: "/api/file/upload.html",
        elem:'#w_img',
        success: function (result) {
            if (result.status == 1) {
                $('#img').attr('src',result.src);
                $('#img').next().val(result.src);
                layer.msg(result.msg,{icon:6});
                return false;
            }
            layer.msg(result.msg,{icon:5});
            
        }
    });

    form.on('submit(create)', function(data){
        data.field.body = layedit.getContent(w_editor);
        $.post(data.form.action,{data:JSON.stringify(data.field)},function(result){
          if (result.code == 1) {
            layer.msg(result.msg,{icon: 6});
            setInterval(function(){
              window.location.href=result.url;
            },result.wait*1000);
            return false;
          }
          layer.msg(result.msg,{icon: 5});
        });
        return false;

    });
    exports('wendiy', function(){});
});