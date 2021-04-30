class Comment extends React.Component {
    constructor(props) {
        super(props);
        this.state = {replies: []};
        this.loadReplies = this.loadReplies.bind(this);
        this.showReplies = this.showReplies.bind(this);
    }

    render() {
        let replies = [];
        if(this.state.replies != null && this.state.replies.length > 0){
            this.state.replies.forEach((comment) => {
                replies.push(<Comment comment={comment} item_id={this.props.item_id} csrf_field={this.props.csrf_field} csrf_hash={this.props.csrf_hash}/>);
            });
        }else if(this.state.replies == null){
            replies = null;
        }
        return (
            <div className="comment_box">
                {this.props.comment != null &&
                    <card className="comment">
                        <header>{`${this.props.comment.first_name} ${this.props.comment.last_name}`}</header>
                        <content>{this.props.comment.comment}</content>
                        <footer>{this.props.comment.timestamp}</footer>
                        <form action='/comment/comment' method="post" acceptCharset="utf-8">
                            {this.props.csrf_field}
                            <textarea name="comment"></textarea>
                            <input name="reply_id" type="number" value={this.props.comment.id} hidden/>
                            <input name="item_id" type="number" value={this.props.item_id} hidden/>
                            <button type="submit">Reply</button>
                        </form>
                    </card>
                }
                <div className="replies">
                    {(replies != null && replies.length > 0 && replies) ||
                    (replies != null && replies.length == 0 &&
                        <button className="load_replies" onClick={this.loadReplies.bind(this)}>Load Replies...</button>)}
                </div>
            </div>
        );
    }

    loadReplies() {
        $.ajax({
            type: 'GET',
            url: `/replies/${this.props.comment.id}`,
            dataType: 'json'
        }).done(this.showReplies);
    }

    showReplies(replies) {
        this.setState({replies: (replies.length > 0)? replies : null});
    }
}

class CommentDisplay extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const comments = [];
        this.props.comments.forEach((comment) => {
            comments.push(<Comment comment={comment} item_id={this.props.item_id} csrf_field={this.props.csrf_field} csrf_hash={this.props.csrf_hash} />);
        });
        return (
            <div>{comments}</div>
        );
    }
}