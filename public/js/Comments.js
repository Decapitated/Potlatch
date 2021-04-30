class Comment extends React.Component {
    constructor(props) {
        super(props);
        this.state = {replies: []};
        this.loadReplies = this.loadReplies.bind(this);
    }

    render() {
        const replies = [];
        this.state.replies.forEach((comment) => {
            replies.push(<Comment comment={comment} />);
        });
        return (
            <div className="comment_box">
                {this.props.comment != null &&
                    <card className="comment">
                        <header>{`${this.props.comment.first_name} ${this.props.comment.last_name}`}</header>
                        <content>{this.props.comment.comment}</content>
                        <footer>{this.props.comment.timestamp}</footer>
                        <form action='http://public.test/comment/comment' method="post">
                            <textarea name="comment"></textarea>
                            <input name="reply_id" type="number" value={this.props.comment.id} hidden/>
                            <input name="item_id" type="number" value={this.props.item_id} hidden/>
                            <button type="submit">Reply</button>
                        </form>
                    </card>
                }
                <div className="replies">
                    {(replies.length > 0 && replies) ||
                    (replies != null &&
                        <button className="load_replies" onClick={this.loadReplies.bind(this)}>Load Replies...</button>)}
                </div>
            </div>
        );
    }

    loadReplies() {
        alert("Load replies");
    }
}

class CommentDisplay extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const comments = [];
        this.props.comments.forEach((comment) => {
            comments.push(<Comment comment={comment} item_id={this.props.item_id}/>);
        });
        return (
            <div>{comments}</div>
        );
    }
}