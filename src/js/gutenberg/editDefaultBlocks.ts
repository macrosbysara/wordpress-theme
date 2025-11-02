import addFlexReverseToggle from '@choctawnationofoklahoma/wp-flex-reverse-toggle';

function alterBlocks(): void {
	const namespace = 'cno-starter-theme';
	addFlexReverseToggle( namespace );
}
alterBlocks();
