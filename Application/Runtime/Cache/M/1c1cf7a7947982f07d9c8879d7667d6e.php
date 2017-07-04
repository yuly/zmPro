<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>联系信息</title>
    <link href="http://zmPro.com/Public/M/css/admin.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://zmPro.com/Public/M/js/jquery-1.8.0.min.js"></script>

    <script type="text/javascript" src="http://zmPro.com/Public/M/js/order.js"></script>
    <script type="text/javascript" src="http://zmPro.com/Public/M/js/dialog/layer.js"></script>
    <script type="text/javascript" src="http://zmPro.com/Public/M/js/dialog.js"></script>
</head>
<style type="text/css">
    body{ background:#EEEEEE;margin:0; padding:0; font-family:"微软雅黑", Arial, Helvetica, sans-serif; }
    a{ color:#006600; text-decoration:none;}
    a:hover{color:#990000;}
    .info select{ border:1px #993300 solid; background:#FFFFFF;}
    .info{
        margin-left: 5%;
        padding-left: 6px;
    }
</style>
<body class="grzxbjk">
<form action="<?php echo U('Cartpay/alipay');?>" id="form-mobile" method="post">
    <div class="srmtop">填写收货信息</div>
    <div class="singzhms yjtpbh order-input">
        <input name="consignee" id="consignee" type="text" placeholder="收货人姓名"/>
    </div>
    <div class="singzhms yjtpbh order-input">
        <input name="mobile" id="mobile" type="number" placeholder = "收货人手机号"/>
    </div>
    <div class="info" style="display: none">
        <div>
            <select id="s_province" name="s_province"></select>  
            <select id="s_city" name="s_city" ></select>  
            <select id="s_county" name="s_county"></select>
            <script class="resources library" src="http://zmPro.com/Public/M/js/area.js" type="text/javascript"></script>
            <script type="text/javascript">_init_area();</script>
        </div>
    </div>

    <div class="singzhms yjtpbh order-input">
        <input name="city1" id="city1" type="text" placeholder="省份/城市/区县" style="width:100%;"/>
    </div>
    <div class="singzhms yjtpbh order-input">
        <input name="city2" id="city2" type="text" placeholder="详细地址，如街道、门牌号等" style="width:100%;"/>
    </div>
    <input type="hidden" name="order_sn" value="<?php echo ($res["order_sn"]); ?>"/>
    <input type="hidden" name="pay_type" id="pay_type" value="ali"/>
</form>
<div class="srmtop">选择支付方式</div>
<div class="zfxzfs">
    <p onclick="selRadio('ali')" class="zfyxhx">
    	<label class="radio">
            <input type="radio" class="btnRadio btn-ali" checked="checked" name="TR">
            <i></i>支付宝支付<img src="http://zmPro.com/Public/M/images/26.jpg" />
        </label>
    </p>
    <p onclick="selRadio('wx')">
    	<label class="radio">
            <input type="radio" class="btnRadio btn-wx" name="TR" >
            <i></i>微信支付<img src="http://zmPro.com/Public/M/images/27.jpg" />
        </label>
    </p>
    <div class="wxzfsmwz" style="display: none;">
        <img src="<?php echo U('Order/wechatpaymenter',array('order_sn'=>$res['order_sn']));?>" />
        <h1>方式一：用其他手机微信扫描此二维码即可付款；</h1>
        <h1>方式二：保存二维码，在微信端识别二维码付款；</h1>
        <h1>方式三：微信搜索“真米如初官网”公众号，关注并进入网站购买；</h1>
    </div>
</div>
<div class="dlzcan" onclick="nextToPay()">
    <input name="" id="nextTo" type="button" value="下一步"/>
</div>

<script type="text/javascript">
    $("#city1").click(function () {
        $(".info").show();
        $("#city1").hide();
    });
    $("#s_county").change(function() {
        var str = $('#s_province').val()+"/"
                + $('#s_city').val()+"/"
                + $('#s_county').val();
        $("#city1").val(str);
        $("#city1").show();
        $(".info").hide();
    });
</script>

</body>
<script>
    function selRadio(type) {
        var toUrl = "<?php echo U('Order/ajax_deal_orderSn');?>";
        $("#pay_type").val(type);
        if (checkInputMsg()){
            $.post(
                    toUrl,
                    $("#form-mobile").serialize(),
                    function (e) {
                        if(type == 'ali'){
                            $(".wxzfsmwz").hide();
                            $("#nextTo").val('下一步');
                        }
                    },"JSON");
        }
    }
    function nextToPay() {
        var flag = $("#nextTo").val();
        var pay_type = $('#pay_type').val();
        if (pay_type == 'none'){
            layer.msg('请选择支付方式',{'time':1000});
        }else {
            if (checkInputMsg()){
                if(flag == '再逛逛'){
                    window.location.href = "<?php echo U('Index/index');?>";
                }
                if (pay_type == 'wx'){
                        $(".wxzfsmwz").show();
                        $("#nextTo").val('再逛逛');
                }else{
                    $("#form-mobile").submit();
                }
            }
        }
    }
    function checkInputMsg() {
        var flag,flag1,flag2,flag3;
        flag = noMsgTip($("#city2"));
        flag1 = noMsgTip($("#city1"));
        flag2 = noMsgTip($("#mobile"));
        flag3 = noMsgTip($("#consignee"));
        if(flag && flag1 && flag2 && flag3){
            return true;
        }else {
            return false;
        }

    }
    function noMsgTip(tag) {
        var msg = tag.val();
        var tip =tag.attr('placeholder');
        var phoneNumReg = /^1(3|4|5|7|8)\d{9}$/;
        if (msg == '' || msg.length == 0){
            layer.msg('请输入'+tip,{'time':1000});
            return false;
        }else {
            if (tag.attr('name') == 'mobile'){
                if (!phoneNumReg.test(msg)){
                    layer.msg('请输入正确的手机号码!',{time:1500});
                    return false;
                }
            }
            return true;
        }
    }
</script>
</html>