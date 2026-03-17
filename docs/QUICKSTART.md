# Quick Start: License Sync Workflow

This guide helps you get started with the manual GPL license sync workflow that downloads and maintains multiple GPL licenses.

## For Template Users

If you're using this template repository, the license sync workflow is available for manual use:

1. **Create your repository from this template**
2. **Trigger the workflow manually when needed:**
   - Go to Actions tab → Sync Licenses → Run workflow
   - Automatic scheduling is disabled - you control when licenses are updated

The workflow downloads and syncs:
- GPL-3.0 (primary license in LICENSE file)
- GPL-2.0
- LGPL-3.0
- LGPL-2.1

All licenses are stored in the `licenses/` directory with the primary GPL-3.0 in the root LICENSE file.

**Note:** Automatic monthly updates are disabled. Licenses must be updated manually by triggering the workflow.

## For Enterprise Environments

If your organization has strict firewall rules, follow these steps:

### Step 1: Test Connectivity

Run the test script to check if your environment can access www.gnu.org:

```bash
./scripts/test-firewall.sh
```

### Step 2: Configure Firewall (if needed)

If the test fails, configure your firewall to allow:

- **Domain:** `www.gnu.org`
- **Protocol:** HTTPS
- **Port:** 443

See [docs/FIREWALL_CONFIGURATION.md](FIREWALL_CONFIGURATION.md) for detailed firewall configuration examples.

### Step 3: Retest

After configuring the firewall, run the test again:

```bash
./scripts/test-firewall.sh
```

All tests should pass before enabling the workflow.

## Manual Trigger

To manually run the workflow:

1. Go to your repository on GitHub
2. Click the **Actions** tab
3. Select **Sync Licenses** workflow
4. Click **Run workflow** button
5. Click **Run workflow** to confirm

## What Happens

When the workflow runs:

1. ✅ Tests connectivity to all license sources (www.gnu.org and ftp.gnu.org)
2. ✅ Downloads multiple GPL licenses (GPL-2.0, GPL-3.0, LGPL-2.1, LGPL-3.0)
3. ✅ Validates all downloaded licenses
4. ✅ Copies GPL-3.0 to root LICENSE file with copyright header
5. ✅ Stores additional licenses in `licenses/` directory
6. ✅ Commits and pushes if any licenses changed

## Viewing Results

After the workflow runs:

- Check the **Actions** tab for workflow status
- View detailed logs by clicking on the workflow run
- The LICENSE file will be created/updated in your repository
- See the workflow summary for detailed information

## Troubleshooting

### Workflow Fails with "Cannot resolve www.gnu.org"

**Cause:** DNS resolution is blocked or failing

**Solution:** Ensure DNS queries are allowed in your firewall

### Workflow Fails with "Cannot connect to www.gnu.org"

**Cause:** HTTPS connections to www.gnu.org are blocked

**Solution:** Configure firewall to allow HTTPS (port 443) to www.gnu.org

### Workflow Succeeds but LICENSE Not Committed

**Cause:** License content hasn't changed since last run

**Solution:** This is normal. The workflow only commits when changes are detected.

## Need Help?

- 📖 [Full Firewall Configuration Guide](FIREWALL_CONFIGURATION.md)
- 📖 [Implementation Summary](IMPLEMENTATION_SUMMARY.md)
- 📖 [Workflow Documentation](../.github/workflows/README.md)
- 📧 Contact: hello@mokoconsulting.tech

## Advanced Configuration

### Enable Automatic Updates

Automatic updates are currently disabled. To enable automatic monthly updates:

1. Edit `.github/workflows/download-license.yml`
2. Uncomment the `schedule` trigger:
   ```yaml
   on:
     workflow_dispatch:  # Keep manual trigger
     schedule:           # Uncomment to enable automatic updates
       - cron: '0 0 1 * *'  # Run monthly
   ```

### Change Schedule

If you enable automatic updates, you can customize the schedule:

```yaml
schedule:
  # Run weekly (every Monday at midnight)
  - cron: '0 0 * * 1'
  
  # Run daily at midnight
  - cron: '0 0 * * *'
  
  # Run quarterly (1st day of Jan, Apr, Jul, Oct)
  - cron: '0 0 1 1,4,7,10 *'
```

### Use with Self-Hosted Runners

For self-hosted GitHub Actions runners:

1. Ensure the runner has internet access
2. Configure firewall on the runner host
3. Test connectivity using `./scripts/test-firewall.sh`
4. If using a proxy, configure it in the workflow:

```yaml
env:
  HTTP_PROXY: http://proxy.example.com:8080
  HTTPS_PROXY: http://proxy.example.com:8080
```

## Security Notes

- Workflow uses minimal permissions (`contents: write` only)
- Downloads only from trusted gnu.org domains
- Validates downloaded content before committing
- All steps are logged for audit purposes

## Best Practices

1. ✅ Test connectivity before deploying to production
2. ✅ Review firewall logs if workflow fails
3. ✅ Keep workflow file in version control
4. ✅ Monitor workflow runs in the Actions tab
5. ✅ Update firewall rules if gnu.org IPs change
