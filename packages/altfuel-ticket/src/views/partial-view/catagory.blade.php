<select name="" id="parent_cat" class="select2"></select>
<select name="catagory" id="child_cat" class="select2"></select>
<script>
    var parent_cat = $('#parent_cat')
    send_ajax_get_request(
        "{{ route('ATRoutes.catagory.getAllParent') }}",
        function(data){
            
            data.forEach(element => {
                parent_cat.append(new Option(`${element.name}`, element.id));
            });
        }
    );
    parent_cat.on('change', function(){
        getChildrenByParentId($(this).val())
        console.log($(this).val());
    })
    function getChildrenByParentId(parentId){
        var url = "{{ route('ATRoutes.catagory.getChildrenByParentId', ['parent_id' => 'parent_id']) }}";
        url = url.replace('parent_id', parentId)
        var child_cat = $('#child_cat')
        send_ajax_get_request(
            url,
            function(data){
                child_cat.html('');
                data.forEach(element => {
                    child_cat.append(new Option(element.name, element.id))
                });
                console.log(data);
            }
        )
    }
</script>