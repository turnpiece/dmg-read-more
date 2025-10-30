const Save = ({ attributes }) => {
    if (!attributes.selectedPostId || !attributes.selectedPostTitle || !attributes.selectedPostUrl) {
        return <p className="dmg-read-more">No post selected.</p>;
    }

    return (
        <p className="dmg-read-more">
            <a href={attributes.selectedPostUrl} target="_blank" rel="noopener noreferrer">
                Read More: {attributes.selectedPostTitle}
            </a>
        </p>
    );
};

export default Save;
