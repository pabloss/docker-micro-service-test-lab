export default {
    install: function (Vue, options) {
        Vue.prototype.Constants = {
            TARGET_FILE_KEY: "target_file",
            TARGET_DIR_KEY: "target_dir",
            PROGRESS_KEY: "progress",
            UUID: "uuid",
            CONNECT_WITH: "connect_with",
            CREATED: "created",
            UPDATED: "updated",
            INIT_KEY: "init",
            MAX_KEY: "max",
            TEST_KEY: "test",
            INDEX_KEY: "uuid",
            BASE_HOST: "service-test-lab-new.local",
            WS_PORT: 4444,
        }
    }
}
