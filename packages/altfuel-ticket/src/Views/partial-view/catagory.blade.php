<div class="row">
    <select name="" id="parent_cat" class="parent-cat form-control col-sm-4"></select>
    <select name="catagory" id="child_cat" class="child-cat form-control col-sm-4 "></select>
</div>
<script>
    $(document).ready(function() {
        var parent_cat = $('.parent-cat')
        send_ajax_get_request(
            "{{ route('ATRoutes.catagory.getAllParent') }}",
            function(data) {
                parent_cat.html('');
                data.forEach(element => {
                    parent_cat.append(new Option(`${element.name}`, element.id));
                });
                getChildrenByParentId($('.parent-cat').val())
                $('.parent-cat').val($('.parent-cat').val())
                // $('.child-cat').val($('.child-cat').val())
            }
        );
        parent_cat.on('change', function() {
            getChildrenByParentId($(this).val())
            $('.parent-cat').val($(this).val())
        })
        var count;

        function getChildrenByParentId(parentId) {
            @if (auth()->user()->access('new-tickets-counter'))
                var url =
                    "{{ route('ATRoutes.catagory.getChildrenByParentId', ['parent_id' => 'parent_id', 'count' => 'count']) }}";
                url = url.replace('parent_id', parentId)
            @else
                var url =
                    "{{ route('ATRoutes.catagory.getChildrenByParentId', ['parent_id' => 'parent_id']) }}";
                url = url.replace('parent_id', parentId)
            @endif
            var child_cat = $('.child-cat')
            child_cat.html('');
            send_ajax_get_request(
                url,
                function(data) {
                    child_cat.html('');
                    data.forEach(element => {
                        if (element.count) {
                            child_cat.append(
                                new Option(
                                    element.name + '(' + element.count + ')',
                                    element.id
                                )
                            )
                        } else {
                            child_cat.append(
                                new Option(
                                    element.name,
                                    element.id
                                )
                            )
                        }


                    });
                }
            )
        }

    })
</script>
