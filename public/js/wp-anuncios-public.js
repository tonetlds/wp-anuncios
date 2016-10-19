(function( $ ) {
	'use strict';

	$(document).ready(function() {

		$.each( $('.wp-anuncio:visible'), function(index, el) {

			console.log( el.getAttribute('data-id') );

			ga('set', 'campaignName', 'anuncio_'+el.getAttribute('data-id') );

			ga('send', 'event', 'anuncio_'+el.getAttribute('data-id'), 'view', window.location.href , {
			  	nonInteraction: true
			});
		});

		$('.wp-anuncio:visible').click(function(e) {
			e.preventDefault();

			ga('set', 'campaignName', 'anuncio_'+$(this).data('id') );

			ga('send', 'event', 'anuncio_'+$(this).data('id'), 'click', $(this).attr('href'), {
				nonInteraction: false
			});

			console.log('Clicked ad #' + $(this).data('id'), "Opening " + $(this).attr('href').toString() );

			window.open($(this).attr('href'),'_blank');			

			return false;
		});

	});



	// Initialize Firebase
	  // var config = {
	  //   apiKey: "AIzaSyCYIpxZvPMnkT90exHPRCh87PwKgzf2qsE",
	  //   authDomain: "wp-anuncios.firebaseapp.com",
	  //   databaseURL: "https://wp-anuncios.firebaseio.com",
	  //   storageBucket: "wp-anuncios.appspot.com",
	  // };
	  // firebase.initializeApp(config);

	 //  	function writeUserData(userId, name, email) {
		//   firebase.database().ref('users/' + userId).set({
		//     username: name,
		//     email: email
		//   });
		// }

		// function sendAnuncioEvent(uid, username, title, body) {
		//   // A anuncio entry.
		//   var anuncioData = {
		//     author: username,
		//     uid: uid,
		//     body: body,
		//     title: title,
		//     starCount: 0
		//   };

		//   // Get a key for a new Anuncio.
		//   var newAnuncioKey = firebase.database().ref().child('anuncios').push().key;

		//   // Write the new anuncio's data simultaneously in the anuncios list and the user's anuncio list.
		//   var updates = {};
		//   updates['/anuncios/' + newAnuncioKey] = anuncioData;
		//   updates['/user-anuncios/' + uid + '/' + newAnuncioKey] = anuncioData;

		//   return firebase.database().ref().update(updates);
		// }

		// firebase.createUserWithEmailAndPassword()

})( jQuery );
