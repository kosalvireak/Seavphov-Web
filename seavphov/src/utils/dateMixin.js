export const DateMixin = {
  methods: {
    formatDate(date) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(date).toLocaleDateString("en-US", options);
    },
    formatDifferentDate(date) {
      const created_at = new Date(date);
      const today = new Date();
      const timeDiff = today - created_at;
      const daysDiff = timeDiff / (1000 * 60 * 60 * 24);
      if (Math.floor(daysDiff) == 0) {
        return "Today";
      } else if (Math.floor(daysDiff) == 1) {
        return "Yesterday";
      } else {
        return Math.floor(daysDiff) + " days ago";
      }
    },
  },
};
