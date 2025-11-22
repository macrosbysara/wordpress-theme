import { Panel, PanelBody } from '@wordpress/components';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/editor';
import ExcerptValidation from './ExcerptValidation';

export default function RenderSidebar() {
	return (
		<>
			<PluginSidebarMoreMenuItem target="pre-publish-checks">
				Pre-Publish Checks
			</PluginSidebarMoreMenuItem>
			<PluginSidebar name="pre-publish-checks" title="Pre-Publish Checks">
				<Panel>
					<PanelBody>
						<h2>Pre-Publish settings</h2>
						<ExcerptValidation />
					</PanelBody>
				</Panel>
			</PluginSidebar></>
	);
}
