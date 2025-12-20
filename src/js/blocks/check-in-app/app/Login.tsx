import { useState } from '@wordpress/element';

type JwtResponse = {
	token: string;
	user_display_name: string;
};

export function Login() {
	const [ username, setUsername ] = useState( '' );
	const [ password, setPassword ] = useState( '' );
	const [ error, setError ] = useState<string | null>( null );

	const login = async () => {
		setError( null );

		// 1. JWT login
		const jwtRes = await fetch( '/wp-json/jwt-auth/v1/token', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify( { username, password } ),
		} );

		if ( ! jwtRes.ok ) {
			setError( 'Invalid credentials' );
			return;
		}

		const jwt: JwtResponse = await jwtRes.json();
		const token = jwt.token;

		// 2. Sync WP cookies
		const syncRes = await fetch( '/wp-json/app/v1/wp-login-sync', {
			method: 'POST',
			headers: {
				Authorization: `Bearer ${ token }`,
			},
			credentials: 'include',
		} );

		if ( ! syncRes.ok ) {
			setError( 'WP session sync failed' );
			return;
		}

		console.log( 'Logged in:', jwt.user_display_name );
	};

	return (
		<div>
			<input
				type="text"
				placeholder="Username"
				value={ username }
				onChange={ ( e ) => setUsername( e.target.value ) }
			/>
			<input
				type="password"
				placeholder="Password"
				value={ password }
				onChange={ ( e ) => setPassword( e.target.value ) }
			/>
			<button onClick={ login }>Log in</button>

			{ error && <p>{ error }</p> }
		</div>
	);
}
