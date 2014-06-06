M.local_getkey = {

	handleJSONP : function (data) {
		//alert('get response'+data);
		//Y.one("#jpoutput").setHTML(M.util.get_string('keyis', 'local_getkey') +data.key);
		//debugger;
		window.location.href="index.php?k="+data.key;

    },
    
    handleFailure : function (data) {
	    alert("Ajax request failed");
	},

   submit_form: function(e) {
	    var Y = this.Y;
	    // Stop the form submitting normally
	    e.preventDefault();
	
	    // Form serialisation works best if we get the form using getElementById, for some reason
	    var form = document.getElementById('mform1');
	    var fname= form.firstname.value;
	    var lname = form.lastname.value;
	    var email = form.email.value;
	    var domain = form.domain.value;
	    var fdata = {
	    		firstname: fname,
	    		lastname: lname,
	    		email: email,
	    		domain:domain
	    		};
	   
	    form = Y.JSON.stringify(fdata);
	    
	     
	    // If your form has a cancel button, you need to disable it, otherwise it'll be sent with the request
	    // and Moodle will think your form was cancelled
	    //Y.one('#id_cancel').set('disabled', 'disabled');
	
	    // Send the request
	    Y.jsonp('https://www.vidyamantra.com/portal/getvmkey.php?data='+form, {
		    method: 'GET',
	        on: {
	            success: this.handleJSONP,
	            failure: this.handleFailure       
	        },
	        context: this
	    }); 
    },


    init: function(Y) {
        var context = M.local_getkey;
        this.Y=Y;						
		Y.one('#id_submitbutton').on('click', this.submit_form,this);      
    }
}

