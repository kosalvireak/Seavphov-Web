export const DateMixin = {
  methods: {
    formatDate(date) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(date).toLocaleDateString("en-US", options);
    },
    formatDifferentDate(date) {
      const daysDiff = this.getDaysDiff(date);
      if (Math.floor(daysDiff) == 0) {
        return "Today";
      } else if (Math.floor(daysDiff) == 1) {
        return "Yesterday";
      } else {
        return Math.floor(daysDiff) + " days ago";
      }
    },
    formatDifferentDays(date) {
      const daysDiff = new Date(date) / (1000 * 60 * 60 * 24);
      if (Math.floor(daysDiff) <= 1) {
        return daysDiff + " day.";
      } else {
        return daysDiff + " days.";
      }
    },

    getDaysDiff(date) {
      const created_at = new Date(date);
      const today = new Date();
      const timeDiff = today - created_at;
      return timeDiff / (1000 * 60 * 60 * 24);
    }


  },
};
