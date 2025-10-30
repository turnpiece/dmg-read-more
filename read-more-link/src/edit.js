import { useState } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, SelectControl, Spinner } from '@wordpress/components';

const Edit = ({ attributes, setAttributes }) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(1);

    // Using useSelect instead of useEntityRecords
    const { posts, isResolving } = useSelect((select) => {
        const query = {
            per_page: 5,
            page: currentPage,
            search: searchTerm,
            status: 'publish',
            _fields: 'id,title,link'
        };

        return {
            posts: select('core').getEntityRecords('postType', 'post', query),
            isResolving: select('core/data').isResolving('core', 'getEntityRecords', ['postType', 'post', query])
        };
    }, [searchTerm, currentPage]);

    const handlePostSelect = (post) => {
        setAttributes({
            selectedPostId: post.id,
            selectedPostTitle: post.title.rendered,
            selectedPostUrl: post.link
        });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title="Select a Post">
                    <TextControl
                        label="Search Posts"
                        value={searchTerm}
                        onChange={setSearchTerm}
                        placeholder="Enter post title or ID"
                    />
                    {isResolving ? <Spinner /> : (
                        <>
                            {posts?.length ? posts.map(post => (
                                <Button
                                    key={post.id}
                                    isSecondary
                                    onClick={() => handlePostSelect(post)}
                                    style={{ display: 'block', margin: '5px 0' }}
                                >
                                    {post.title.rendered}
                                </Button>
                            )) : <p>No posts found.</p>}
                            <SelectControl
                                label="Page"
                                value={currentPage}
                                options={[...Array(10).keys()].map(i => ({
                                    label: `Page ${i + 1}`,
                                    value: i + 1
                                }))}
                                onChange={(value) => setCurrentPage(parseInt(value))}
                            />
                        </>
                    )}
                </PanelBody>
            </InspectorControls>
            <p className="dmg-read-more">
                {attributes.selectedPostId ? (
                    <a href={attributes.selectedPostUrl} target="_blank" rel="noopener noreferrer">
                        Read More: {attributes.selectedPostTitle}
                    </a>
                ) : (
                    "Select a post to display a Read More link."
                )}
            </p>
        </>
    );
};

export default Edit;
