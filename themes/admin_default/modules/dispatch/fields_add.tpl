<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<form action="{FORM_ACTION}" method="post">
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <td>
                    {LANG.fields_name} (<span style="color:red">*</span>)
                </td>
                <td>
                    <input class="form-control w400" value="{DATA.title}" name="title" id="title" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="btn btn-primary" type="submit" name="submit" value="{LANG.save}" />
                </td>
            </tr>
        </tbody>
    </table>
</form>
<!-- END: main -->