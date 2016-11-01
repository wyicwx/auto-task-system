<ol class="breadcrumb">
    <li><a href="/user/list">个人中心</a></li>
    <li class="active">修改密码</li>
</ol>


<h1>修改密码</h1>
<div class="row">
    <div class="col-lg-5">
        <form action="/user/password" method="post" role="form">
            <input type="hidden" name="_csrf-frontend" value="">

            <div class="form-group">
                <label class="control-label" for="loginform-username">原密码</label>
                <input type="text" id="loginform-username" class="form-control" name="LoginForm[username]" autofocus="">
            </div>
                            
            <div class="form-group">
                <label class="control-label" for="loginform-password">新密码</label>
                <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]">
            </div>

            <div class="form-group">
                <label class="control-label" for="loginform-repassword">重复密码</label>
                <input type="password" id="loginform-repassword" class="form-control" name="LoginForm[password]">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="login-button">保存</button>
            </div>
        </form>        
    </div>
</div>