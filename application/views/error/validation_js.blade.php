<script>
  function alertClose($id){
      var alert_id = $("#"+$id).closest("div").parent().parent().attr("id");
      $("#"+alert_id).slideUp("slow", function(){
          $(this).remove();
      });
  }
</script>
