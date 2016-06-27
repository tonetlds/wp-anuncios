<?php
if ( class_exists( 'RWMB_Field' ) )
{
    class RWMB_Statistics_Field extends RWMB_Field
    {	   
	    static public function html( $meta, $field ){

	    	$postID 			= get_the_ID();
	    	$anuncio_url 		= get_post_meta( $postID, 'anuncio_url', true ) 		? get_post_meta( $postID, 'anuncio_url', true ) 		: 0;
			$anuncio_views 		= get_post_meta( $postID, 'anuncio_views', true ) 		? get_post_meta( $postID, 'anuncio_views', true ) 		: 0;
			$anuncio_sessions 	= get_post_meta( $postID, 'anuncio_sessions', true ) 	? get_post_meta( $postID, 'anuncio_sessions', true ) 	: 0;
			$anuncio_clicks 	= get_post_meta( $postID, 'anuncio_clicks', true ) 		? get_post_meta( $postID, 'anuncio_clicks', true ) 		: 0;

			// $output  = '<h3 id="%s">'.$anuncio_views.' <small>%s</small></h3>';
			// $output .= '<br/>';
			// $output .= '<p>%s</p>';

			$output  = '<table id="%s" width="%s" border="0">
							<tr>
								<td align="center" width="%s">
									<h3>%s </h3>
									<p>%s</p>
								</td>
								<td align="center" width="%s">
									<h3>%s</h3>
									<p>%s</p>
								</td>
								<td align="center" width="%s">
									<h3>%s</h3>
									<p>%s</p>
								</td>
							</tr>
						</table>';

		    return sprintf(
		        $output,
		        $field['id'],
		        '100%',
		        '33%',
		        $anuncio_views,
		        'Exibiçoes',
		        '33%',
		        $anuncio_sessions,
		        'Pessoas',
		        '33%',
		        $anuncio_clicks,
		        'Cliques',
		        $meta,
		        $field['field_name'],
		        $field['descr']
		    );
		}

    }

}